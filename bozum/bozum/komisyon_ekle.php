<?php
session_start();
if (!isset($_SESSION['yonetici_id'])) {
    header("Location: giris.php");
    exit();
}

include 'ayar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

        $sql = "INSERT INTO KomisyonOranlari (alt_sinir, ust_sinir, komisyon_orani) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$alt_sinir, $ust_sinir, $komisyon_orani]);

        header("Location: komisyon.php?success=1");
        exit();
    } catch (PDOException $e) {
        header("Location: komisyon.php?success=0");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Komisyon Ekle</title>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
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
                <?php include 'navbar.php'; ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row gy-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Komisyon Ekle</h5>
                                        <form action="komisyon_ekle.php" method="POST">
                                            <div class="mb-3">
                                                <label for="alt_sinir" class="form-label">Alt Sınır</label>
                                                <input type="text" class="form-control number-only" id="alt_sinir" name="alt_sinir" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="ust_sinir" class="form-label">Üst Sınır</label>
                                                <input type="text" class="form-control number-only" id="ust_sinir" name="ust_sinir" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="komisyon_orani" class="form-label">Komisyon Oranı</label>
                                                <input type="text" class="form-control number-only" id="komisyon_orani" name="komisyon_orani" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Komisyon Ekle</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
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

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.number-only').forEach(function (input) {
            input.addEventListener('input', function () {
                this.value = this.value.replace(/[^\d.,]/g, ''); 
            });
        });
    });
    </script>
</body>
</html>
