<?php

session_start();


if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    
    
    $_SESSION = [];
    
   
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),                 
            '',                             
            time() - 42000,                  
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    
    
    session_destroy();
    
    
    session_start();
    $_SESSION['logout_message'] = "Vous avez été déconnecté avec succès.";
    
   
    header('Location: login.php');
    exit;
}


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