<?php

require __DIR__ . '/../includes/session.php';

$_SESSION = [];
session_destroy();

redirect('login');
