<?php

require __DIR__ . '/../../includes/session.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('profile');
}

$errors = [];
$userId = $_SESSION['user_id'];

$name = clean($_POST['name'] ?? '');
$email = clean($_POST['email'] ?? '');
$phone = clean($_POST['phone'] ?? '');
$password = $_POST['password'] ?? '';
$passwordConfirm = $_POST['password_confirm'] ?? '';

if ($name === '') {
    $errors[] = 'Введите имя';
}

if ($email === '') {
    $errors[] = 'Введите email';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Некорректный email';
}

$phone = preg_replace('/\D+/', '', $phone);
if ($phone === '') {
    $errors[] = 'Введите телефон';
}

if ($password !== '' || $passwordConfirm !== '') {
    if ($password !== $passwordConfirm) {
        $errors[] = 'Пароли не совпадают';
    }
}

if ($errors) {
    $_SESSION['errors'] = $errors;
    redirect('profile');
}

$stmt = $pdo->prepare("
    SELECT id, email, phone
    FROM users
    WHERE (email = :email OR phone = :phone)
      AND id != :id
    LIMIT 1
");
$stmt->execute([
    'email' => $email,
    'phone' => $phone,
    'id' => $userId
]);

if ($user = $stmt->fetch()) {
    $_SESSION['errors'][] =
        $user['email'] === $email
            ? 'Email уже используется'
            : 'Телефон уже используется';

    redirect('profile');
}

$fields = [
    'name' => $name,
    'email' => $email,
    'phone' => $phone
];

$sql = "UPDATE users SET name = :name, email = :email, phone = :phone";

if ($password !== '') {
    $sql .= ", password = :password";
    $fields['password'] = password_hash($password, PASSWORD_DEFAULT);
}

$sql .= " WHERE id = :id";
$fields['id'] = $userId;

$stmt = $pdo->prepare($sql);
$stmt->execute($fields);

$_SESSION['success'] = 'Данные сохранены';
redirect('profile');
