<?php
session_start();
if (!isset($_SESSION['yonetici_id'])) {
    header("Location: giris.php");
    exit();
}

include 'ayar.php';

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    try {
        $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        );

        $pdo = new PDO($dsn, $username, $password, $options);

        $sql = "DELETE FROM KomisyonOranlari WHERE komisyon_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        echo 'success';
    } catch (PDOException $e) {
        echo 'error: ' . $e->getMessage();
    }
}
?>
