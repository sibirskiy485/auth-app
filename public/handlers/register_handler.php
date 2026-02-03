<?php

require __DIR__ . '/../../includes/session.php';
require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/functions.php';
require __DIR__ . '/../../includes/smartcaptcha.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('register');
}

$errors = [];

$name     = clean($_POST['name'] ?? '');
$email    = clean($_POST['email'] ?? '');
$phone    = clean($_POST['phone'] ?? '');
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
} elseif (strlen($phone) < 10) {
    $errors[] = 'Некорректный номер телефона';
}

if ($password === '' || $passwordConfirm === '') {
    $errors[] = 'Введите пароль и подтверждение';
} elseif ($password !== $passwordConfirm) {
    $errors[] = 'Пароли не совпадают';
}

if ($errors) {
    $_SESSION['errors'] = $errors;
    redirect('register');
}

// Проверка уникальности
$stmt = $pdo->prepare("
    SELECT email, phone 
    FROM users 
    WHERE email = :email OR phone = :phone
    LIMIT 1
");
$stmt->execute([
    'email' => $email,
    'phone' => $phone
]);

if ($user = $stmt->fetch()) {
    $_SESSION['errors'][] =
        $user['email'] === $email
            ? 'Email уже зарегистрирован'
            : 'Телефон уже зарегистрирован';

    redirect('register');
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("
    INSERT INTO users (name, email, phone, password)
    VALUES (:name, :email, :phone, :password)
");

$stmt->execute([
    'name'     => $name,
    'email'    => $email,
    'phone'    => $phone,
    'password' => $passwordHash
]);

$_SESSION['user_id'] = $pdo->lastInsertId();

redirect('profile');
