<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/header.php';



?>


<h2>Ajouter un livre</h2>
<form method="post" action="/bibliotheque/livres/ajout_livre.php">

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
        <select name="annee" id="annee">
            <option value="">-- Sélectionnez --</option>
            <?php for ($year = date('Y'); $year >= 0000; $year--): ?>
            <option value="<?= $year ?>"><?= $year ?></option>
            <?php endfor; ?>
        </select>

    </div>
    <div>
        <label for="isbn">ISBN :</label>
        <input type="text" name="isbn" id="isbn">
    </div>
    <button type="submit" class="btn">Ajouter</button>
    <a href="index.php" class="btn">Annuler</a>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>