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
    $yonetici_adi = $_POST['yonetici_adi'];
    $eposta = $_POST['eposta'];
    $sifre = $_POST['sifre']; // Şifreyi düz metin olarak kaydediyoruz.

    $profil_resmi = null;
    if (isset($_FILES['profil_resmi']) && $_FILES['profil_resmi']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profil_resmi']['tmp_name'];
        $fileName = $_FILES['profil_resmi']['name'];
        $fileSize = $_FILES['profil_resmi']['size'];
        $fileType = $_FILES['profil_resmi']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        
        $allowedfileExtensions = array('jpg', 'jpeg', 'png', 'gif');
        
        if (in_array($fileExtension, $allowedfileExtensions)) {
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = 'img/';
            $dest_path = $uploadFileDir . $newFileName;
            
            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                $profil_resmi = $dest_path;
            } else {
                echo 'Dosya yüklenirken bir hata oluştu.';
                exit();
            }
        } else {
            echo 'Desteklenmeyen dosya türü.';
            exit();
        }
    } else {
        echo 'Görsel yüklenmedi.';
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

        $sql = "INSERT INTO Yonetici (yonetici_adi, eposta, sifre, profil_resmi) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$yonetici_adi, $eposta, $sifre, $profil_resmi]);

        header("Location: yonetici.php?success=1");
        exit();
    } catch (PDOException $e) {
        header("Location: yonetici.php?success=0");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Yönetici Ekle</title>
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
                                        <h5 class="card-title">Yönetici Ekle</h5>
                                        <form action="yonetici_ekle.php" method="POST" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="yonetici_adi" class="form-label">Ad</label>
                                                <input type="text" class="form-control" id="yonetici_adi" name="yonetici_adi" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="eposta" class="form-label">Eposta</label>
                                                <input type="email" class="form-control" id="eposta" name="eposta" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="sifre" class="form-label">Şifre</label>
                                                <input type="password" class="form-control" id="sifre" name="sifre" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="profil_resmi" class="form-label">Profil Resmi</label>
                                                <input type="file" class="form-control" id="profil_resmi" name="profil_resmi" accept="image/*" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Yönetici Ekle</button>
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
</body>
</html>
