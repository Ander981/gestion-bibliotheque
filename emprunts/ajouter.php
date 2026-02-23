<?php
// emprunts/ajouter.php
require_once __DIR__ . '/../config/database.php'; // Contient maintenant getPDO()
require_once __DIR__ . '/../includes/auth_check.php';

$host = 'localhost';
$dbname = 'bibliotheque'; // à adapter
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}


// Initialisation des variables
$livres = [];
$membres = [];
$error = null;

try {
    // Requête pour obtenir les livres non empruntés actuellement
    // (date_retour_effective IS NULL signifie que le livre n'a pas été rendu)
    $sql = "
        SELECT l.id, l.titre 
        FROM livres l
        LEFT JOIN emprunts e ON l.id = e.livre_id AND e.date_retour_effective IS NULL
        WHERE e.id IS NULL
        ORDER BY l.titre
    ";
    $stmt = $pdo->query($sql);
    $livres = $stmt->fetchAll();

    // Requête pour obtenir tous les membres
    $stmt = $pdo->query("SELECT id, nom, prenom FROM membres ORDER BY nom, prenom");
    $membres = $stmt->fetchAll();

} catch (PDOException $e) {
    $error = "Erreur lors de la récupération des données : " . $e->getMessage();
}

// Inclusion de l'en-tête de la page
require_once __DIR__ . '/../includes/header.php';
?>

<h2>Nouvel emprunt</h2>

<?php if ($error): ?>
<p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="post" action="/bibliotheque/emprunts/ajout_emprunt.php">
    <div>
        <label for="livre_id">Livre :</label>
        <select name="livre_id" id="livre_id" required>
            <option value="">Choisissez un livre</option>
            <?php if (!empty($livres)): ?>
            <?php foreach ($livres as $livre): ?>
            <option value="<?= $livre['id'] ?>">
                <?= htmlspecialchars($livre['titre']) ?>
            </option>
            <?php endforeach; ?>
            <?php else: ?>
            <option value="" disabled>Aucun livre disponible</option>
            <?php endif; ?>
        </select>
        <?php if (empty($livres)): ?>
        <p style="color:orange;">Aucun livre disponible pour le moment.</p>
        <?php endif; ?>
    </div>

    <div>
        <label for="membre_id">Membre :</label>
        <select name="membre_id" id="membre_id" required>
            <option value="">Choisissez un membre</option>
            <?php if (!empty($membres)): ?>
            <?php foreach ($membres as $membre): ?>
            <option value="<?= $membre['id'] ?>">
                <?= htmlspecialchars($membre['prenom'] . ' ' . $membre['nom']) ?>
            </option>
            <?php endforeach; ?>
            <?php else: ?>
            <option value="" disabled>Aucun membre enregistré</option>
            <?php endif; ?>
        </select>
        <?php if (empty($membres)): ?>
        <p style="color:orange;">Aucun membre trouvé.</p>
        <?php endif; ?>
    </div>

    <div>
        <label for="date_emprunt">Date d'emprunt :</label>
        <input type="date" name="date_emprunt" id="date_emprunt" value="<?= date('Y-m-d') ?>" required>
    </div>

    <div>
        <label for="date_retour_prevue">Date de retour prévue :</label>
        <input type="date" name="date_retour_prevue" id="date_retour_prevue"
            value="<?= date('Y-m-d', strtotime('+15 days')) ?>" required>
    </div>

    <button type="submit" class="btn">Enregistrer l'emprunt</button>
    <a href="index.php" class="btn">Annuler</a>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>