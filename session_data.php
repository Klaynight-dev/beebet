<?php
session_start();

header('Content-Type: application/json');

if (isset($_SESSION['userToken'])) {
    echo json_encode([
        'loggedIn' => true,
        'username' => $_SESSION['username'] ?? 'Unknown',
        'coins' => $_SESSION['coins'] ?? 0,
        'avatar_url' => $_SESSION['avatar_url'] ?? 'default_avatar.png'
    ]);
} else {
    echo json_encode(['loggedIn' => false]);
}
?>
