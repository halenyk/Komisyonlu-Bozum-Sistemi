<?php
session_start();
if (!isset($_SESSION['yonetici_id'])) {
    header("Location: giris.php");
    exit();
}

include 'ayar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $islem_id = $_POST['islem_id'];
    $komisyon_orani = $_POST['komisyon_orani'];
    $durum = $_POST['durum'];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     
        $stmt = $conn->prepare("
            UPDATE BozumIslemleri 
            SET durum = :durum 
            WHERE islem_id = :islem_id
        ");
        $stmt->bindParam(':durum', $durum, PDO::PARAM_STR);
        $stmt->bindParam(':islem_id', $islem_id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $conn->prepare("
            UPDATE KomisyonOranlari ko
            JOIN BozumIslemleri bi ON ko.komisyon_id = bi.komisyon_id
            SET ko.komisyon_orani = :komisyon_orani
            WHERE bi.islem_id = :islem_id
        ");
        $stmt->bindParam(':komisyon_orani', $komisyon_orani, PDO::PARAM_STR);
        $stmt->bindParam(':islem_id', $islem_id, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: bozum.php?status=success&message=İşlem başarıyla güncellendi.");
        exit();
    } catch(PDOException $e) {
        header("Location: bozum.php?status=error&message=Hata: " . $e->getMessage());
        exit();
    }
}
?>
