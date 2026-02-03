<?php
$title = 'Профиль';

require __DIR__ . '/../includes/session.php';
require __DIR__ . '/../includes/functions.php';
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../config/db.php';
require __DIR__ . '/../includes/header.php';

$action = '/handlers/profile_handler.php';
$mode = 'edit';

$stmt = $pdo->prepare("
    SELECT id, name, email, phone
    FROM users
    WHERE id = :id
    LIMIT 1
");
$stmt->execute([
    'id' => $_SESSION['user_id']
]);

$user = $stmt->fetch();

if (!$user) {
    redirect('/pages/logout.php');
}

include __DIR__ . '/../templates/user_form.php';

require __DIR__ . '/../includes/footer.php';
