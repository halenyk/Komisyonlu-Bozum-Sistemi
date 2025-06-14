<?php
session_start();
if (!isset($_SESSION['yonetici_id'])) {
    header("Location: giris.php");
    exit();
}

include 'ayar.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="komisyon_oranlari.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, array('Alt Sınır', 'Üst Sınır', 'Komisyon Oranı'));

try {
    $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    );

    $pdo = new PDO($dsn, $username, $password, $options);
    
    $sql = "SELECT alt_sinir, ust_sinir, komisyon_orani FROM KomisyonOranlari";
    $stmt = $pdo->query($sql);

    while ($row = $stmt->fetch()) {
        fputcsv($output, $row);
    }

} catch (PDOException $e) {
    die("Veritabanı hatası: " . $e->getMessage());
}

fclose($output);
?>
