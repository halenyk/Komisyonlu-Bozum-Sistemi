<?php
session_start();
if (!isset($_SESSION['yonetici_id'])) {
    header("Location: giris.php");
    exit();
}

include 'ayar.php';

setlocale(LC_TIME, 'tr_TR.UTF-8'); 

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 20;
$offset = ($page - 1) * $limit;

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
      LIMIT :limit OFFSET :offset
    ");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $countStmt = $conn->prepare("SELECT COUNT(*) FROM BozumIslemleri");
    $countStmt->execute();
    $totalRecords = $countStmt->fetchColumn();
    $totalPages = ceil($totalRecords / $limit);
} catch(PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Bozum İşlemleri</title>
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
                        <?php if (isset($_GET['status']) && isset($_GET['message'])): ?>
                        <div class="alert alert-<?php echo $_GET['status'] == 'success' ? 'success' : 'danger'; ?>" role="alert" id="statusMessage">
                            <?php echo htmlspecialchars($_GET['message']); ?>
                        </div>
                        <?php endif; ?>
                        <div class="row gy-4">
                            <!-- Data Tables -->
                            <div class="col-12">
                                <div class="card">
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
                                                    <th class="text-truncate">Durum</th>
                                                    <th class="text-truncate">İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!empty($results)) {
                                                    foreach ($results as $row) {
                                                        $formattedDate = strftime("%e %B %Y", strtotime($row['islem_tarihi']));
                                                        $formattedTime = date("H:i:s", strtotime($row['islem_tarihi']));
                                                        echo "<tr id='row-{$row['islem_id']}'>
                                                                <td>{$row['ad']}</td>
                                                                <td>{$row['soyad']}</td>
                                                                <td>{$row['miktar']}</td>
                                                                <td>{$row['komisyon_orani']}</td>
                                                                <td>{$row['net_miktar']}</td>
                                                                <td>{$formattedDate} {$formattedTime}</td>
                                                                <td class='durum'>{$row['durum']}</td>
                                                                <td>
                                                                    <a href='bozum_duzenle.php?islem_id={$row['islem_id']}' class='btn btn-primary'>Düzenle</a>
                                                                </td>
                                                              </tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='8'>Veri bulunamadı.</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--/ Data Tables -->
                            <!-- Pagination -->
                            <div class="col-12">
                                <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                                    <ul class="pagination">
                                        <?php
                                        for ($i = 1; $i <= $totalPages; $i++) {
                                            $active = ($i == $page) ? 'active' : '';
                                            echo "<li class='page-item $active'><a class='page-link' href='bozum.php?page={$i}'>{$i}</a></li>";
                                        }
                                        ?>
                                    </ul>
                                </nav>
                            </div>
                            <!-- / Pagination -->
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
        <script>
            $(document).ready(function(){
                setTimeout(function() {
                    $('#statusMessage').fadeOut('slow');
                }, 3000); 
            });
        </script>
    </div>
</body>
</html>
