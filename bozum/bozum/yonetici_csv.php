<?php
include 'ayar.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="yonetici_bilgileri.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, array('Yönetici ID', 'Yönetici Adı', 'Eposta', 'Profil Resmi'));

try {
    $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    );

    $pdo = new PDO($dsn, $username, $password, $options);
    
    $sql = "SELECT yonetici_id, yonetici_adi, eposta, profil_resmi FROM Yonetici";
    $stmt = $pdo->query($sql);

    while ($row = $stmt->fetch()) {
        fputcsv($output, $row);
    }

} catch (PDOException $e) {
    die("Veritabanı hatası: " . $e->getMessage());
}

fclose($output);
?>
