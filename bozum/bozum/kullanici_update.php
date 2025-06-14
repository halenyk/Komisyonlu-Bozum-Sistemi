<?php
session_start();
if (!isset($_SESSION['yonetici_id'])) {
    header("Location: giris.php");
    exit();
}
include 'ayar.php';

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $ad = $_POST['ad'];
    $soyad = $_POST['soyad'];
    $IBAN = $_POST['IBAN'];
    $banka = $_POST['banka'];

    try {
        $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        );

        $pdo = new PDO($dsn, $username, $password, $options);

        $sql = "UPDATE Kullanicilar SET ad = ?, soyad = ?, IBAN = ?, banka = ? WHERE kullanici_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$ad, $soyad, $IBAN, $banka, $id]);

        header("Location: kullanici.php?success=1");
        exit();
    } catch (PDOException $e) {
        header("Location: kullanici.php?success=0");
        exit();
    }
}
?>
