<?php
// config/database.php

/**
 * Fonction utilitaire pour récupérer une variable d'environnement
 * (fonctionne avec getenv() et $_ENV)
 */
function getEnvVar($name) {
    // D'abord avec getenv() (plus fiable dans certains environnements)
    $value = getenv($name);
    if ($value !== false) {
        return $value;
    }
    // Sinon avec $_ENV
    if (isset($_ENV[$name])) {
    return $_ENV[$name];
}

$value = getenv($name);
return $value !== false ? $value : null;

}

// ============================================
// ENVIRONNEMENT DE PRODUCTION (Vercel)
// ============================================
if (getenv('VERCEL') || isset($_ENV['VERCEL'])) {
    
    // Récupération des variables d'environnement
    $host     = getEnvVar('DB_HOST');
    $dbname   = getEnvVar('DB_NAME');
    $username = getEnvVar('DB_USER');
    $password = getEnvVar('DB_PASSWORD');
    $ssl      = getEnvVar('DB_SSL'); // Optionnel : 'require' ou true/false

    // Vérification que toutes les variables requises sont présentes
    if (!$host || !$dbname || !$username || !$password) {
        // En cas d'erreur, on logge pour le débogage (visible dans les logs Vercel)
        error_log("DB_HOST: " . ($host ?: 'MANQUANT'));
        error_log("DB_NAME: " . ($dbname ?: 'MANQUANT'));
        error_log("DB_USER: " . ($username ?: 'MANQUANT'));
        error_log("DB_PASSWORD: " . ($password ?: 'MANQUANT'));
        die("Erreur : Variables d'environnement de base de données manquantes.");
    }

    // Construction du DSN (Data Source Name) pour PostgreSQL
    $dsn = "pgsql:host=$host;dbname=$dbname";

    // Ajout de l'option SSL si demandée (requis pour Neon)
    if ($ssl === 'require' || $ssl === 'true' || $ssl === '1') {
        $dsn .= ";sslmode=require";
    }

    // Options PDO supplémentaires
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Mode exception pour les erreurs
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch en tableau associatif par défaut
        PDO::ATTR_EMULATE_PREPARES   => false,                  // Utiliser les vraies requêtes préparées
    ];

// ============================================
// ENVIRONNEMENT LOCAL (WAMP)
// ============================================
} else {
    
    // Configuration pour MySQL local
    $host     = 'localhost';
    $dbname   = 'bibliotheque';
    $username = 'root';
    $password = '';
    
    // DSN pour MySQL
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    
    // Options PDO pour MySQL
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
}

// ============================================
// CONNEXION À LA BASE DE DONNÉES
// ============================================
try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    // Message d'erreur générique (ne pas exposer les détails en production)
    if (getenv('VERCEL') || isset($_ENV['VERCEL'])) {
        error_log("Erreur de connexion BDD: " . $e->getMessage());
        die("Erreur de connexion à la base de données. Veuillez réessayer plus tard.");
    } else {
        // En local, on peut afficher l'erreur détaillée
        die("Erreur de connexion : " . $e->getMessage());
    }
}

// ============================================
// FONCTIONS UTILES (optionnel)
// ============================================

/**
 * Exemple : fonction pour exécuter une requête préparée en toute sécurité
 * (à déplacer dans un fichier séparé si nécessaire)
 */
function executeQuery($pdo, $sql, $params = []) {
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        error_log("Erreur SQL: " . $e->getMessage() . " - SQL: " . $sql);
        throw $e;
    }
}

?>