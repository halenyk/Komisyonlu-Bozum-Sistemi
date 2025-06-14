<?php
$servername = "localhost";
$username = "haleyumu_test";
$password = "203658sb.";
$dbname = "haleyumu_bozum";

try {
    $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    );

    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("Veritabanına bağlantı hatası: " . $e->getMessage());
}
?>
