<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title ?? 'Auth App' ?></title>

    <link rel="stylesheet" href="/assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"></script>
    <?php if (!empty($isCaptchaEnabled)): ?>
        <script src="https://smartcaptcha.yandexcloud.net/captcha.js" defer></script>
    <?php endif; ?>
</head>
<body>

<header class="container">

    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/index.php">Главная</a>
        </li>

        <?php if (!empty($_SESSION['user_id'])): ?>
            <li class="nav-item">
                <a class="nav-link" href="/?page=profile">Профиль</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/?page=logout">Выйти</a>
            </li>
        <?php else: ?>
            <li class="nav-item">
                <a class="nav-link" href="/?page=login">Войти</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/?page=register">Регистрация</a>
            </li>
        <?php endif; ?>

    </ul>
</header>

<main class="container">
