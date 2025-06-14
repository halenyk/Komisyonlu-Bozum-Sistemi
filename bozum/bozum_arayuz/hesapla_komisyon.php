<?php
include 'db.php';

if (isset($_GET['miktar']) && is_numeric($_GET['miktar'])) {
    $miktar = $_GET['miktar'];

    try {
        // PDO bağlantısını oluştur
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Sorguyu hazırla ve çalıştır
        $stmt = $pdo->prepare("SELECT * FROM KomisyonOranlari WHERE :miktar BETWEEN alt_sinir AND ust_sinir");
        $stmt->bindParam(':miktar', $miktar, PDO::PARAM_INT);
        $stmt->execute();

        // Sonuçları al
        $komisyonSonucu = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($komisyonSonucu) {
            $komisyonOrani = $komisyonSonucu['komisyon_orani'];
            $komisyon = ($miktar * $komisyonOrani) / 100;
            $netMiktar = $miktar - $komisyon;
            echo json_encode(['net_miktar' => $netMiktar, 'komisyon_orani' => $komisyonOrani]);
        } else {
            echo json_encode(['net_miktar' => 'Komisyon oranı bulunamadı', 'komisyon_orani' => 0]);
        }
    } catch (PDOException $e) {
        echo json_encode(['net_miktar' => 'Hata: ' . $e->getMessage(), 'komisyon_orani' => 0]);
    }
} else {
    echo json_encode(['net_miktar' => 'Geçersiz miktar', 'komisyon_orani' => 0]);
}

// PDO bağlantısını kapat
$pdo = null;
?>
