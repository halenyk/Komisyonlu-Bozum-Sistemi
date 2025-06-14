<?php
include 'ayar.php';

// CSV dosyası oluşturma
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=kullanicilar.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array('Ad', 'Soyad', 'IBAN', 'Banka'));

try {
    $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    );

    $pdo = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT ad, soyad, IBAN, banka FROM Kullanicilar";
    $stmt = $pdo->query($sql);

    while ($row = $stmt->fetch()) {
        fputcsv($output, $row);
    }
} catch (PDOException $e) {
    echo 'error: ' . $e->getMessage();
}

fclose($output);
?>
