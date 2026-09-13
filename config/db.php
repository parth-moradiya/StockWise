<?php
/**
 * StockWise Retail Solutions - Database Connection
 */

// ---- Connection settings -------------------------------------------------
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'stockwise_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// ---- Create the PDO connection -------------------------------------------
$dsn = 'mysql:host=' . DB_HOST
     . ';port=' . DB_PORT
     . ';dbname=' . DB_NAME
     . ';charset=' . DB_CHARSET;

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    error_log('Database connection failed: ' . $e->getMessage());
    die('Sorry, the site is temporarily unavailable. Please try again later.');
}