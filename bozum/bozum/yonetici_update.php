<?php
session_start();
if (!isset($_SESSION['yonetici_id'])) {
    header("Location: giris.php");
    exit();
}

include 'ayar.php';

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $yonetici_adi = $_POST['yonetici_adi'];
    $eposta = $_POST['eposta'];
    $profil_resmi = $_POST['profil_resmi'];

    try {
        $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        );

        $pdo = new PDO($dsn, $username, $password, $options);

        $sql = "UPDATE Yonetici SET yonetici_adi = ?, eposta = ?, profil_resmi = ? WHERE yonetici_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$yonetici_adi, $eposta, $profil_resmi, $id]);

        header("Location: yonetici.php?success=1");
        exit();
    } catch (PDOException $e) {
        header("Location: yonetici.php?success=0");
        exit();
    }
}
?>
