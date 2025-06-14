<?php
session_start();
if (!isset($_SESSION['yonetici_id'])) {
    header("Location: giris.php");
    exit();
}

include 'ayar.php';

$islem_id = isset($_GET['islem_id']) ? (int)$_GET['islem_id'] : 0;

if ($islem_id === 0) {
    echo "Geçersiz işlem ID'si.";
    exit;
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("
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
        WHERE bi.islem_id = :islem_id
    ");
    $stmt->bindParam(':islem_id', $islem_id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo "Veri bulunamadı.";
        exit;
    }
} catch(PDOException $e) {
    echo "Hata: " . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Bozum İşlemi Düzenle</title>
    <meta name="description" content="" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/vendor/fonts/materialdesignicons.css" />
    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="../assets/vendor/libs/node-waves/node-waves.css" />
    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />
    <!-- Page CSS -->
    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <?php include 'menu.php'; ?>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <?php include 'navbar.php'; ?>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row gy-4">
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Bozum İşlemi Düzenle</h5>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="bozum_guncelle.php">
                                            <input type="hidden" name="islem_id" value="<?php echo $row['islem_id']; ?>">
                                            <div class="mb-3">
                                                <label class="form-label" for="ad">İsim</label>
                                                <input type="text" class="form-control" name="ad" value="<?php echo $row['ad']; ?>" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="soyad">Soyisim</label>
                                                <input type="text" class="form-control" name="soyad" value="<?php echo $row['soyad']; ?>" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="miktar">Miktar</label>
                                                <input type="text" class="form-control" name="miktar" value="<?php echo $row['miktar']; ?>"readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="komisyon_orani">Komisyon Oranı</label>
                                                <input type="text" class="form-control" name="komisyon_orani" value="<?php echo $row['komisyon_orani']; ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="net_miktar">Net Miktar</label>
                                                <input type="text" class="form-control" name="net_miktar" value="<?php echo $row['net_miktar']; ?>"readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="islem_tarihi">İşlem Tarihi</label>
                                                <input type="text" class="form-control" name="islem_tarihi" value="<?php echo $row['islem_tarihi']; ?>" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="durum">Durum</label>
                                                <select class="form-control" name="durum">
                                                    <option value="Bekleyen" <?php if ($row['durum'] == 'Bekleyen') echo 'selected'; ?>>Beklemede</option>
                                                    <option value="Onaylandı" <?php if ($row['durum'] == 'Onaylandı') echo 'selected'; ?>>Onaylandı</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-success">Kaydet</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="message"></div>
                    </div>
                    <!-- / Content -->
                </div>
                <!-- / Content wrapper -->
            </div>
            <!-- / Layout container -->
        </div>
        <!-- / Layout wrapper -->

        <!-- Core JS -->
        <script src="../assets/vendor/libs/jquery/jquery.js"></script>
        <script src="../assets/vendor/libs/popper/popper.js"></script>
        <script src="../assets/vendor/js/bootstrap.js"></script>
        <script src="../assets/vendor/libs/node-waves/node-waves.js"></script>
        <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
        <script src="../assets/vendor/js/menu.js"></script>
        <!-- Vendors JS -->
        <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>
        <!-- Main JS -->
        <script src="../assets/js/main.js"></script>
        <!-- Page JS -->
        <script src="../assets/js/dashboards-analytics.js"></script>
        <!-- Place this tag in your head or just before your close body tag. -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
    </div>
</body>
</html>
