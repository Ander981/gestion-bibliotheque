<?php

// Si on a déjà confirmé (via paramètre GET), on déconnecte
if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    // Détruire la session
    session_destroy();
    // Stocker un message de confirmation dans la session (pour l'afficher sur login.php)
    session_start(); // On redémarre une session pour stocker le message
    $_SESSION['logout_message'] = "Vous avez été déconnecté avec succès.";
    header('Location: login.php');
    exit;
}

// Sinon, on affiche une page de confirmation
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Déconnexion</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <div class="login-container"
        style="max-width:400px; margin:50px auto; padding:20px; background:#fff; border-radius:5px; text-align:center;">
        <h2>Confirmation de déconnexion</h2>
        <p>Êtes-vous sûr de vouloir vous déconnecter ?</p>
        <a href="?confirm=yes" class="btn" style="background:#d9534f; color:#fff;">Oui, déconnecter</a>
        <a href="javascript:history.back()" class="btn" style="background:#5bc0de; color:#fff;">Annuler</a>
    </div>
</body>

</html>