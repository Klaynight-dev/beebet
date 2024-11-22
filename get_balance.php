<?php
require 'config.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$token = isset($input['token']) ? $input['token'] : null;

if (!$token) {
    echo json_encode(['error' => 'Token non fourni']);
    http_response_code(401);
    exit();
}

try {
    $stmt = $pdo->prepare('SELECT id, coins FROM users WHERE token = :token');
    $stmt->execute(['token' => $token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode(['error' => 'Token non valide']);
        http_response_code(401);
        exit();
    }

    echo json_encode(['coins' => $user['coins']]);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur lors de la récupération du solde: ' . $e->getMessage()]);
    http_response_code(500);
}
?>
