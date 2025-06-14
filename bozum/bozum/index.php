<?php
session_start();
if (!isset($_SESSION['yonetici_id'])) {
    header("Location: giris.php");
    exit();
}

include 'ayar.php';

$yonetici_adi = $_SESSION['yonetici_adi'];

$bu_ay = date('Y-m');
$gecen_ay = date('Y-m', strtotime('-1 month'));

// Bu ayın toplam bozum miktarını al
$stmt = $pdo->prepare("SELECT SUM(miktar) as toplam_miktar FROM BozumIslemleri WHERE DATE_FORMAT(islem_tarihi, '%Y-%m') = :bu_ay");
$stmt->execute(['bu_ay' => $bu_ay]);
$toplam_miktar = $stmt->fetchColumn();

// Geçen ayın toplam bozum miktarını al
$stmt = $pdo->prepare("SELECT SUM(miktar) as toplam_miktar FROM BozumIslemleri WHERE DATE_FORMAT(islem_tarihi, '%Y-%m') = :gecen_ay");
$stmt->execute(['gecen_ay' => $gecen_ay]);
$gecen_ay_toplam_miktar = $stmt->fetchColumn();

$toplam_kullanici_stmt = $pdo->prepare("SELECT COUNT(*) as toplam_kullanici FROM Kullanicilar");
$toplam_kullanici_stmt->execute();
$toplam_kullanici = $toplam_kullanici_stmt->fetchColumn();

$aktif_komisyon_stmt = $pdo->prepare("SELECT COUNT(*) as aktif_komisyon FROM KomisyonOranlari");
$aktif_komisyon_stmt->execute();
$aktif_komisyon = $aktif_komisyon_stmt->fetchColumn();

$son_bes_islem_stmt = $pdo->prepare("
    SELECT 
        bi.islem_id, 
        k.ad, 
        k.soyad, 
        bi.miktar, 
        ko.komisyon_orani, 
        bi.net_miktar, 
        bi.islem_tarihi, 
        bi.durum 
    FROM BozumIslemleri bi
    JOIN Kullanicilar k ON bi.kullanici_id = k.kullanici_id
    JOIN KomisyonOranlari ko ON bi.komisyon_id = ko.komisyon_id
    ORDER BY bi.islem_tarihi DESC
    LIMIT 5
");
$son_bes_islem_stmt->execute();
$son_bes_islem = $son_bes_islem_stmt->fetchAll(PDO::FETCH_ASSOC);

// Büyüme oranını hesapla
$buyume_orani = 0;
if ($gecen_ay_toplam_miktar > 0) {
    $buyume_orani = (($toplam_miktar - $gecen_ay_toplam_miktar) / $gecen_ay_toplam_miktar) * 100;
}
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum=1.0" />
    <title>Anasayfa</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/vendor/fonts/materialdesignicons.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />
    <script src="../assets/vendor/js/helpers.js"></script>
    <script src="../assets/js/config.js"></script>
</head>
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include 'menu.php'; ?>
            <div class="layout-page">
                <?php include 'navbar.php' ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row gy-4">
                            <div class="col-md-12 col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-1">Hoşgeldin, <?php echo htmlspecialchars($yonetici_adi); ?></h4>
                                        <p class="pb-0">Bu ay yapılan toplam bozum</p>
                                        <h4 class="text-primary mb-1">₺<?php echo number_format($toplam_miktar, 2, ',', '.'); ?></h4>
                                        <br>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                Hızlı İşlemler
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li><a class="dropdown-item" href="bozum.php"><i class="mdi mdi-currency-usd"></i> Bozum İşlemleri</a></li>
                                                <li><a class="dropdown-item" href="komisyon.php"><i class="mdi mdi-percent"></i> Komisyon Bölümü</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <img src="../assets/img/icons/misc/triangle-light.png" class="scaleX-n1-rtl position-absolute bottom-0 end-0" width="166" alt="triangle background" data-app-light-img="icons/misc/triangle-light.png" data-app-dark-img="icons/misc/triangle-dark.png" />
                                    <img src="../assets/img/illustrations/trophy.png" class="scaleX-n1-rtl position-absolute bottom-0 end-0 me-4 mb-4 pb-2" width="83" alt="view sales" />
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h5 class="card-title m-0 me-2">Genel Durum</h5>
                                        </div>
                                        <p class="mt-3">
                                            <span class="fw-medium">
                                                <?php
                                                if ($buyume_orani > 0) {
                                                    echo "Bu ay toplam " . number_format($buyume_orani, 2, ',', '.') . "% büyüme";
                                                } elseif ($buyume_orani < 0) {
                                                    echo "Bu ay toplam " . number_format(abs($buyume_orani), 2, ',', '.') . "% küçülme";
                                                } else {
                                                    echo "Bu ay değişiklik yok";
                                                }
                                                ?>
                                            </span>  
                                        </p>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-4 col-6">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar">
                                                        <div class="avatar-initial bg-primary rounded shadow">
                                                            <i class="mdi mdi-account-outline mdi-24px"></i>
                                                        </div>
                                                    </div>
                                                    <div class="ms-3">
                                                        <div class="small mb-1">Kullanıcılar</div>
                                                        <h5 class="mb-0"><?php echo $toplam_kullanici; ?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-6">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar">
                                                        <div class="avatar-initial bg-success rounded shadow">
                                                            <i class="mdi mdi-percent mdi-24px"></i>
                                                        </div>
                                                    </div>
                                                    <div class="ms-3">
                                                        <div class="small mb-1">Aktif Komisyonlar</div>
                                                        <h5 class="mb-0"><?php echo $aktif_komisyon; ?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-6">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar">
                                                        <div class="avatar-initial bg-warning rounded shadow">
                                                            <i class="mdi mdi-currency-usd mdi-24px"></i>
                                                        </div>
                                                    </div>
                                                    <div class="ms-3">
                                                        <div class="small mb-1">Bu Ayki Bozum</div>
                                                        <h5 class="mb-0">₺<?php echo number_format($toplam_miktar, 2, ',', '.'); ?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Son 5 Bozum İşlemi</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th class="text-truncate">İsim</th>
                                                        <th class="text-truncate">Soyisim</th>
                                                        <th class="text-truncate">Miktar</th>
                                                        <th class="text-truncate">Komisyon Oranı</th>
                                                        <th class="text-truncate">Net Miktar</th>
                                                        <th class="text-truncate">İşlem Tarihi</th>
                                                        <th class="text-truncate">Saat</th>
                                                        <th class="text-truncate">Durum</th>
                                                        <th class="text-truncate">İşlemler</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (!empty($son_bes_islem)) {
                                                        setlocale(LC_TIME, 'tr_TR.UTF-8');
                                                        foreach ($son_bes_islem as $row) {
                                                            $formattedDate = strftime("%e %B %Y", strtotime($row['islem_tarihi']));
                                                            $formattedTime = date("H:i:s", strtotime($row['islem_tarihi']));
                                                            echo "<tr id='row-{$row['islem_id']}'>
                                                                    <td>{$row['ad']}</td>
                                                                    <td>{$row['soyad']}</td>
                                                                    <td>₺" . number_format($row['miktar'], 2, ',', '.') . "</td>
                                                                    <td>%{$row['komisyon_orani']}</td>
                                                                    <td>₺" . number_format($row['net_miktar'], 2, ',', '.') . "</td>
                                                                    <td>{$formattedDate}</td>
                                                                    <td>{$formattedTime}</td>
                                                                    <td class='durum'>{$row['durum']}</td>
                                                                    <td>
                                                                        <a href='bozum_duzenle.php?islem_id={$row['islem_id']}' class='btn btn-primary'>Detaylar</a>
                                                                    </td>
                                                                  </tr>";
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan='9'>Veri bulunamadı.</td></tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional content or summary cards can be added here -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>
    <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/dashboards-analytics.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>
</html>
