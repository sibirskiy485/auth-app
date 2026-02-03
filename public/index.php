<?php
require __DIR__ . '/../includes/session.php';

require_once __DIR__ . '/../config/db.php';

$page = $_GET['page'] ?? 'home';

$pages = [
    'home'     => 'home.php',
    'login'    => 'login.php',
    'register' => 'register.php',
    'profile'  => 'profile.php',
    'logout'   => 'logout.php',
];

if (!isset($pages[$page])) {
    http_response_code(404);
    exit;
}

require __DIR__ . '/../pages/' . $pages[$page];
