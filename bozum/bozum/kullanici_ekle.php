<?php
session_start();
if (!isset($_SESSION['yonetici_id'])) {
    header("Location: giris.php");
    exit();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'ayar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ad = $_POST['ad'];
    $soyad = $_POST['soyad'];
    $IBAN = $_POST['IBAN'];
    $banka = $_POST['banka'];

    
    if (!preg_match('/^TR\d{24}$/', $IBAN)) {
        header("Location: kullanici_ekle.php?success=0&error=iban");
        exit();
    }

    try {
        $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        );

        $pdo = new PDO($dsn, $username, $password, $options);

        $sql = "INSERT INTO Kullanicilar (ad, soyad, IBAN, banka) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$ad, $soyad, $IBAN, $banka]);

        header("Location: kullanici.php?success=1");
        exit();
    } catch (PDOException $e) {
        header("Location: kullanici.php?success=0");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Kullanıcı Ekle</title>
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
                <div class="content-wrapper">
                     <?php include 'navbar.php'; ?>
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row gy-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Kullanıcı Ekle</h5>
                                        <form action="kullanici_ekle.php" method="POST">
                                            <div class="mb-3">
                                                <label for="ad" class="form-label">Ad</label>
                                                <input type="text" class="form-control" id="ad" name="ad" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="soyad" class="form-label">Soyad</label>
                                                <input type="text" class="form-control" id="soyad" name="soyad" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="IBAN" class="form-label">IBAN</label>
                                                <input type="text" class="form-control" id="IBAN" name="IBAN" 
                                                       pattern="^TR\d{24}$" title="IBAN, 'TR' ile başlamalı ve ardından 24 rakam içermelidir." 
                                                       minlength="26" maxlength="26" required>
                                                <div class="invalid-feedback">
                                                    Lütfen geçerli bir IBAN giriniz. ('TR' ile başlamalı ve ardından 24 rakam içermelidir.)
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="banka" class="form-label">Banka</label>
                                                <input type="text" class="form-control" id="banka" name="banka" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Kullanıcı Ekle</button>
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
        var IBANInput = document.getElementById('IBAN');

        IBANInput.addEventListener('input', function (event) {
            this.value = 'TR' + this.value.slice(2).replace(/[^\d]/g, ''); 
        });

        var form = document.querySelector('form');
        form.addEventListener('submit', function (event) {
            if (IBANInput.value.length !== 26 || !/^TR\d{24}$/.test(IBANInput.value)) {
                IBANInput.setCustomValidity('Lütfen geçerli bir IBAN giriniz. (\'TR\' ile başlamalı ve ardından 24 rakam içermelidir.)');
                IBANInput.reportValidity();
                event.preventDefault();
            } else {
                IBANInput.setCustomValidity(''); 
            }
        });
    });
    </script>
</body>
</html>
