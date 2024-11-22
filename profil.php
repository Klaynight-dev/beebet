<?php
session_start();
require 'config.php';


if (!isset($_SESSION['userToken'])) {
    header('Location: index.php');
    exit();
}

$token = $_SESSION['userToken'];

$stmt = $pdo->prepare('SELECT username, coins FROM users WHERE token = :token');
$stmt->execute(['token' => $token]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo 'Utilisateur non trouvé';
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="profile-container">
        <h1>Profil Utilisateur</h1>
        <p>Nom d'utilisateur : <span><?php echo htmlspecialchars($user['username']); ?></span></p>
        <p>Coins : <span>$<?php echo htmlspecialchars($user['coins']); ?></span></p>
        <button id="logout-button">Déconnexion</button>
    </div>

    <script>
        document.getElementById('logout-button').addEventListener('click', function() {
            fetch('logout.php', { method: 'POST' })
                .then(response => {
                    if (response.ok) {
                        window.location.href = 'index.php';
                    } else {
                        alert('Erreur de déconnexion');
                    }
                });
        });
    </script>
</body>
</html>
