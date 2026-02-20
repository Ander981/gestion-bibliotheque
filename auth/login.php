<?php
// auth/login.php

// Démarrer la session si pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Utiliser le chemin absolu avec __DIR__ pour les inclusions
require_once __DIR__ . '/../config/config.php'; // Pour $base_path
require_once __DIR__ . '/../config/database.php';

// Si l'utilisateur (admin) est déjà connecté, redirection
if (isset($_SESSION['user_id'])) {
    header('Location: ' . $base_path . '/index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (!empty($username) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header('Location: ' . $base_path . '/index.php');
            exit;
        } else {
            $error = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion - Bibliothèque</title>
    <link rel="stylesheet" href="<?= $base_path ?>/assets/css/style.css">
</head>

<body>
    <div class="login-container"
        style="max-width:400px; margin:50px auto; padding:20px; background:#fff; border-radius:5px;">
        <h2>Connexion - Bibliothèque</h2>
        <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="post">
            <div style="margin-bottom:15px;">
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" name="username" id="username" required
                    style="width:100%; padding:8px; box-sizing:border-box;">
            </div>
            <div style="margin-bottom:15px;">
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" id="password" required
                    style="width:100%; padding:8px; box-sizing:border-box;">
                <input type="checkbox" id="showPassword" style="margin-left: 8px; width: auto;">
                <label for="showPassword" style="margin-left: 4px; white-space: nowrap;">Afficher</label>
            </div>
            <button type="submit" class="btn"
                style="background:#333; color:#fff; border:none; padding:10px 20px; cursor:pointer;">
                Se connecter
            </button>
        </form>
    </div>
    <script>
    document.getElementById('showPassword').addEventListener('change', function() {
        var passwordField = document.getElementById('password');
        passwordField.type = this.checked ? 'text' : 'password';
    });
    </script>
</body>

</html>