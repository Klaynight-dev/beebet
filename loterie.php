<?php require 'config.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loterie - Casino Roblox</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <h1 class="loterie-title">Loteries en Cours</h1>

    <div class="loterie-container">
        <?php
        $loteries = [
            [
                'name' => 'Loterie 1',
                'description' => 'Description de la loterie 1.',
                'participants' => 150,
                'end_date' => '31/12/2024',
                'price' => 10,
                'reward' => 100
            ],
            [
                'name' => 'Loterie 2',
                'description' => 'Description de la loterie 2.',
                'participants' => 75,
                'end_date' => '15/01/2025',
                'price' => 5,
                'reward' => 50
            ],
            [
                'name' => 'Loterie 3',
                'description' => 'Description de la loterie 3.',
                'participants' => 30,
                'end_date' => '01/02/2025',
                'price' => 8,
                'reward' => 75
            ],
            [
                'name' => 'Loterie 3',
                'description' => 'Description de la loterie 3.',
                'participants' => 30,
                'end_date' => '01/02/2025',
                'price' => 8,
                'reward' => 75
            ],
            
        ];
        ?>

        <?php foreach ($loteries as $loterie): ?>
            <div class="lottery-card">
                <div class="yellow-bar"></div>
                <div class="card-header">
                    <span class="username">asdasdadsadsada</span>
                    <span class="participant"><?php echo htmlspecialchars($loterie['participants']); ?></span>
                    <span class="status-label">Chaud</span>
                </div>
                <img src="assets/img/BeeBetCursedFile.png" alt="Product Image" class="product-image">
                <p class="product-name"><?php echo htmlspecialchars($loterie['name']); ?></p>
                <div class="card-footer">
                    <p><strong>Récompense :</strong> $<?php echo htmlspecialchars($loterie['reward']); ?></p>
                    <p class="countdown"><?php echo htmlspecialchars($loterie['end_date']); ?></p>
                    <button class="preconditions-btn">VIEW PRE-CONDITIONS</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <style>
        .loterie-title {
            text-align: center;
            padding-top: 20px
        }

        .loterie-container {
            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
            gap: 15px;
            justify-content: center; 
            padding: 20px;
            max-width: 1500px;
            margin: 0 auto;
        }

        .loterie-container p {
            color: white;
        }

        .lottery-card {
            background: linear-gradient(to top, rgba(255, 255, 255, 0.1) 70%, rgba(255, 215, 0, 0.2));
            border-radius: 1px;
            padding: 0px;
            text-align: center;
            width: 275px;
            height: 350px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .yellow-bar {
            background-color: #FFD700;
            height: 2px;
            border-top-left-radius: 1px;
            border-top-right-radius: 1px;
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.8), 0 0 20px rgba(255, 215, 0, 0.6);
            padding: 2px;
            margin-bottom: 10px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
        }

        .username {
            color: #f1a33b;
            font-weight: bold;
            margin-left: 10px
        }

        .user-status, .participant, .status-label {
            color: #ccc;
        }

        .status-label {
            background-color: #d9534f;
            padding: 2px 8px;
            border-radius: 5px;
            margin-right: 10px
        }

        .product-image {
            width: 70%;
            height: auto;
            margin: 10px 0;
        }

        .product-name {
            color: #ccc;
            font-size: 16px;
            margin: 10px 0;
        }

        .card-footer {
            background-color: #222;
            padding: 10px;
            margin-top: 11px;
            font-size: 14px;
        }

        .countdown {
            color: #8cc63f;
            margin: 5px 0;
        }

        .preconditions-btn {
            background-color: #f1a33b;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .blur-background {
            width: 100%;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            backdrop-filter: blur(6px);
            background: rgba(34, 34, 34, 0.85);
            z-index: 24;
            visibility: visible;
            opacity: 1;
            transition: backdrop-filter 0.25s ease-in-out;
            pointer-events: all;
        }

        .blur-background--hidden {
            backdrop-filter: blur(0px);
            background: rgba(0, 0, 0, 0);
            z-index: 0;
            visibility: hidden;
            opacity: 0;
            pointer-events: none;
        }
    </style>
    
    <?php include 'blur-back.php'; ?>
    <?php include 'login-box.php'; ?>
    
    <script src="script.js"></script>
</body>
</html>
