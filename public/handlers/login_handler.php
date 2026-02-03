<?php

require __DIR__ . '/../../includes/session.php';
require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/functions.php';
require __DIR__ . '/../../includes/smartcaptcha.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('login');
}

$token = $_POST['smartcaptcha_token'] ?? '';

if ($token === '') {
    $_SESSION['errors'][] = 'Подтвердите, что вы не робот';
    redirect('login');
}

if (!verifySmartCaptcha($token)) {
    $_SESSION['errors'][] = 'Подтвердите, что вы не робот';
    redirect('login');
}

$login    = clean($_POST['login'] ?? '');
$password = $_POST['password'] ?? '';

$errors = [];

if ($login === '' || $password === '') {
    $errors[] = 'Введите логин и пароль';
}

if ($errors) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = compact('login');
    redirect('login');
}

$isEmail = filter_var($login, FILTER_VALIDATE_EMAIL);

if (!$isEmail) {
    $login = preg_replace('/\D+/', '', $login);
}

$stmt = $pdo->prepare("
    SELECT id, password
    FROM users
    WHERE " . ($isEmail ? 'email = :login' : 'phone = :login') . "
    LIMIT 1
");

$stmt->execute(['login' => $login]);
$user = $stmt->fetch();

if (!$user || !password_verify($password, $user['password'])) {
    $_SESSION['errors'][] = 'Неверный логин или пароль';
    redirect('login');
}

$_SESSION['user_id'] = (int)$user['id'];

redirect('profile');
