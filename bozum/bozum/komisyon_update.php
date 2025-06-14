<?php
session_start();
if (!isset($_SESSION['yonetici_id'])) {
    header("Location: giris.php");
    exit();
}

include 'ayar.php';

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $alt_sinir = $_POST['alt_sinir'];
    $ust_sinir = $_POST['ust_sinir'];
    $komisyon_orani = $_POST['komisyon_orani'];

    try {
        $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        );

        $pdo = new PDO($dsn, $username, $password, $options);

        $sql = "UPDATE KomisyonOranlari SET alt_sinir = ?, ust_sinir = ?, komisyon_orani = ? WHERE komisyon_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$alt_sinir, $ust_sinir, $komisyon_orani, $id]);

        header("Location: komisyon.php?success=1");
        exit();
    } catch (PDOException $e) {
        header("Location: komisyon.php?success=0");
        exit();
    }
}
?>
