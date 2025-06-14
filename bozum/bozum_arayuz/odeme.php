<?php
include 'db.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $ad = htmlspecialchars($_POST['ad']);
    $soyad = htmlspecialchars($_POST['soyad']);
    $iban = htmlspecialchars($_POST['iban']);
    $banka = htmlspecialchars($_POST['banka']);
    $miktar = htmlspecialchars($_POST['miktar']);
    $netMiktar = htmlspecialchars($_POST['net_miktar']);
    $komisyonOrani = htmlspecialchars($_POST['komisyon_orani']);

    $stmt = $conn->prepare("SELECT komisyon_id FROM KomisyonOranlari WHERE komisyon_orani = :komisyon_orani");
    $stmt->bindParam(':komisyon_orani', $komisyonOrani, PDO::PARAM_STR);
    $stmt->execute();
    $komisyon = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($komisyon) {
        $komisyonId = $komisyon['komisyon_id'];

        $stmt = $conn->prepare("INSERT INTO Kullanicilar (ad, soyad, iban, banka) VALUES (:ad, :soyad, :iban, :banka)");
        $stmt->bindParam(':ad', $ad);
        $stmt->bindParam(':soyad', $soyad);
        $stmt->bindParam(':iban', $iban);
        $stmt->bindParam(':banka', $banka);
        $stmt->execute();
        $kullaniciId = $conn->lastInsertId();

        $stmt = $conn->prepare("INSERT INTO BozumIslemleri (kullanici_id, miktar, komisyon_id, net_miktar, islem_tarihi, durum) VALUES (:kullanici_id, :miktar, :komisyon_id, :net_miktar, NOW(), 'Bekleyen')");
        $stmt->bindParam(':kullanici_id', $kullaniciId);
        $stmt->bindParam(':miktar', $miktar);
        $stmt->bindParam(':komisyon_id', $komisyonId);
        $stmt->bindParam(':net_miktar', $netMiktar);
        if ($stmt->execute()) {
            echo "İşleminiz başarıyla gerçekleştirildi. Net Miktar: " . $netMiktar . " TL (Komisyon Oranı: " . $komisyonOrani . "%)";
        } else {
            echo "İşlem kaydedilemedi: " . $stmt->errorInfo()[2];
        }
    } else {
        echo "Komisyon oranı bulunamadı.";
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
