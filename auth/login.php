<?php
// auth/login.php

// Déterminer le chemin racine
$root_path = realpath(__DIR__ . '/..');

// Inclure la configuration avec le bon chemin
require_once $root_path . '/config/database.php';

// Vérifier si déjà connecté
if (isset($_SESSION['user_id']) || isset($_SESSION['membre_id'])) {
    header('Location: /index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Version sans opérateur ?? (compatible PHP 5.x)
    $identifiant = isset($_POST['identifiant']) ? trim($_POST['identifiant']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (!empty($identifiant) && !empty($password)) {
        // Vérifier dans utilisateurs (admin)
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE username = ?");
        $stmt->execute([$identifiant]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header('Location: /index.php');
            exit;
        } else {
            // Vérifier dans membres
            $stmt = $pdo->prepare("SELECT id, nom, prenom, email, password FROM membres WHERE email = ?");
            $stmt->execute([$identifiant]);
            $membre = $stmt->fetch();

            if ($membre && password_verify($password, $membre['password'])) {
                $_SESSION['membre_id'] = $membre['id'];
                $_SESSION['membre_nom'] = $membre['nom'];
                $_SESSION['membre_prenom'] = $membre['prenom'];
                $_SESSION['membre_email'] = $membre['email'];
                header('Location: /index.php');
                exit;
            } else {
                $error = "Identifiant ou mot de passe incorrect.";
            }
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
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
    <div class="login-container">
        <h2>Connexion à la bibliothèque</h2>
        <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="post">
            <div>
                <label for="identifiant">Email (membre) ou nom d'utilisateur (admin) :</label>
                <input type="text" name="identifiant" id="identifiant" required>
            </div>
            <div>
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit" class="btn">Se connecter</button>
        </form>
        <p>
            <a href="/inscription.php">Pas encore membre ? Inscrivez-vous</a>
        </p>
    </div>
</body>

</html>