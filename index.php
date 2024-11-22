<?php require 'config.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casino roblox en bienn</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>  

    <?php include 'navbar.php'; ?>

    <?php include 'login-box.php'; ?>
    <?php include 'blur-back.php'; ?>
    <style>
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
    <script src="script.js"></script>
</body>
</html>
