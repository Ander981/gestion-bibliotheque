<?php
// livres/ajouter.php

// Démarrer la session si pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth_check.php';

// Initialiser les variables
$error = '';
$success = false;

// TRAITEMENT DU FORMULAIRE - AVANT tout HTML
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = isset($_POST['titre']) ? trim($_POST['titre']) : '';
    $auteur = isset($_POST['auteur']) ? trim($_POST['auteur']) : '';
    $annee = isset($_POST['annee']) ? $_POST['annee'] : '';
    $isbn = isset($_POST['isbn']) ? trim($_POST['isbn']) : '';

    if (!empty($titre) && !empty($auteur)) {
        $sql = "INSERT INTO livres (titre, auteur, annee, isbn) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$titre, $auteur, $annee ?: null, $isbn ?: null]);
        
        // REDIRECTION - ICI c'est encore sûr car pas de HTML envoyé
        header('Location: index.php');
        exit; // TRÈS IMPORTANT : arrêter l'exécution après redirection
    } else {
        $error = "Veuillez remplir les champs obligatoires.";
    }
}

// MAINTENANT on peut inclure header.php (qui commence à envoyer du HTML)
require_once __DIR__ . '/../includes/header.php';
?>

<h2>Ajouter un livre</h2>

<?php if ($error): ?>
<p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="post">
    <div>
        <label for="titre">Titre :</label>
        <input type="text" name="titre" id="titre" required>
    </div>
    <div>
        <label for="auteur">Auteur :</label>
        <input type="text" name="auteur" id="auteur" required>
    </div>
    <div>
        <label for="annee">Année :</label>
        <input type="number" name="annee" id="annee">
    </div>
    <div>
        <label for="isbn">ISBN :</label>
        <input type="text" name="isbn" id="isbn">
    </div>
    <button type="submit" class="btn">Ajouter</button>
    <a href="index.php" class="btn">Annuler</a>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>