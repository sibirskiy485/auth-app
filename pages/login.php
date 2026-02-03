<?php
$title = 'Логин';
$isCaptchaEnabled = true;

require __DIR__ . '/../includes/session.php';
require __DIR__ . '/../includes/header.php';

$action = '/handlers/login_handler.php';
$mode = 'login';

include __DIR__ . '/../templates/login_form.php';

require __DIR__ . '/../includes/footer.php';
