<?php
// create_super_admin.php
require_once 'config/database.php';

// --- CONFIGURATION ---
$username = 'SuperAdmin';      // Nom d'utilisateur du super admin
$password = 'Ander.04';      // Mot de passe (change-le si besoin)
$role = 'super_admin';        // Rôle souhaité
// ---------------------

// 1. Vérifier / étendre la colonne 'role' si nécessaire (pour les ENUM)
try {
    // Récupérer la définition de la colonne
    $stmt = $pdo->query("SHOW COLUMNS FROM utilisateurs LIKE 'role'");
    $column = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($column && strpos($column['Type'], 'enum') !== false) {
        // C'est un ENUM, on vérifie si 'super_admin' est déjà présent
        preg_match("/^enum\(\'(.*)\'\)$/", $column['Type'], $matches);
        $existing = explode("','", $matches[1]);
        if (!in_array($role, $existing)) {
            // Ajouter 'super_admin' à la liste des valeurs possibles
            $newEnum = "'" . implode("','", array_merge($existing, [$role])) . "'";
            $alter = "ALTER TABLE utilisateurs MODIFY COLUMN role ENUM($newEnum) DEFAULT 'user'";
            $pdo->exec($alter);
            echo "Colonne 'role' étendue pour inclure '$role'.<br>";
        }
    } elseif ($column && strpos($column['Type'], 'varchar') !== false) {
        // Si c'est un varchar, pas de souci
        // On peut laisser tel quel
    } else {
        // Si ce n'est pas un ENUM, on peut aussi laisser
    }
} catch (Exception $e) {
    // En cas d'erreur (table peut-être différente), on continue
}

// 2. Créer ou mettre à jour l'utilisateur
$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user) {
    // Mise à jour du mot de passe et du rôle (optionnel)
    $update = $pdo->prepare("UPDATE utilisateurs SET password = ?, role = ? WHERE username = ?");
    $update->execute([$hash, $role, $username]);
    echo "Mot de passe de l'utilisateur '$username' mis à jour avec le rôle '$role'.<br>";
} else {
    // Création d'un nouvel utilisateur avec le rôle super_admin
    $insert = $pdo->prepare("INSERT INTO utilisateurs (username, password, role) VALUES (?, ?, ?)");
    $insert->execute([$username, $hash, $role]);
    echo "Nouvel utilisateur '$username' créé avec le rôle '$role'.<br>";
}

echo "Opération terminée. Tu peux maintenant supprimer ce fichier pour des raisons de sécurité.";
?>