<?php
require 'config.php';
session_start();

header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['token']) && !empty($data['token'])) {
    $token = $data['token'];

    // Requête à Flask pour générer le nom d'utilisateur
    $ch = curl_init('http://localhost:5000/generate_username');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['token' => $token]));
    $response = curl_exec($ch);

    if ($response === false) {
        echo json_encode(['success' => false, 'message' => 'Erreur cURL : ' . curl_error($ch)]);
        curl_close($ch);
        exit;
    }
    curl_close($ch);

    $response_data = json_decode($response, true);
    
    if (isset($response_data['success']) && $response_data['success']) {
        $username = $response_data['username'];

        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE token = ?");
            $stmt->execute([$token]);
            $user = $stmt->fetch();

            if ($user) {
                $_SESSION['userToken'] = $user['token'];
                $avatar_url = $_SESSION['avatar_url'] ?? 'assets/img/default_avatar.png';

                echo json_encode(['success' => true, 'coins' => $user['coins'], 'avatar_url' => $avatar_url]);
            } else {
                $stmt = $pdo->prepare("INSERT INTO users (username, token, coins) VALUES (?, ?, ?)");
                $stmt->execute([$username, $token, 100]);

                $_SESSION['userToken'] = $token;
                $_SESSION['username'] = $username;
                $_SESSION['coins'] = 100;

                // Faire une requête à Flask pour obtenir l'avatar
                $ch = curl_init('http://localhost:5000/get_avatar');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['token' => $token]));
                $avatar_response = curl_exec($ch);
                curl_close($ch);

                $avatar_data = json_decode($avatar_response, true);
                $avatar_url = $avatar_data['avatar_url'] ?? 'assets/img/default_avatar.png';
                $_SESSION['avatar_url'] = $avatar_url;

                echo json_encode(['success' => true, 'coins' => 100, 'avatar_url' => $avatar_url]);
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Erreur de base de données: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur de génération du nom d’utilisateur.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Token manquant ou vide.']);
}
?>
