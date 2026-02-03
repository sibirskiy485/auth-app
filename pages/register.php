<?php
$title = 'Регистрация';
$isCaptchaEnabled = true;

require __DIR__ . '/../includes/session.php';
require __DIR__ . '/../includes/header.php';

$action = '/handlers/register_handler.php';
$mode = 'register';

include __DIR__ . '/../templates/user_form.php';

require __DIR__ . '/../includes/footer.php';
