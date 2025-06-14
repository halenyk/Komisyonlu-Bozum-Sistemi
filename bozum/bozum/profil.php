<?php
session_start();
if (!isset($_SESSION['yonetici_id'])) {
    header("Location: giris.php");
    exit();
}

include 'ayar.php'; // Veritabanı bağlantısı

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$yonetici_id = $_SESSION['yonetici_id'];

// Yönetici bilgilerini veritabanından çekme
$sql = "SELECT yonetici_adi, eposta, profil_resmi FROM Yonetici WHERE yonetici_id = :yonetici_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':yonetici_id', $yonetici_id, PDO::PARAM_INT);
$stmt->execute();
$yonetici = $stmt->fetch();

if (!$yonetici) {
    echo "Kullanıcı bulunamadı.";
    exit();
}

// Kullanıcı bilgilerini oturum değişkenlerine atama
$_SESSION['yonetici_adi'] = $yonetici['yonetici_adi'];
$_SESSION['eposta'] = $yonetici['eposta'];
$_SESSION['profil_resmi'] = $yonetici['profil_resmi'] ? 'img/' . $yonetici['profil_resmi'] : '../assets/img/avatars/default.png';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $yonetici_adi = $_POST['yoneticiAdi'];
    $eposta = $_POST['eposta'];
    $profil_resmi = $yonetici['profil_resmi']; // Mevcut profil resmi

    // Yeni fotoğraf yüklenmişse
    if (isset($_FILES['profil_resmi']) && $_FILES['profil_resmi']['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['profil_resmi']['tmp_name'];
        $filename = basename($_FILES['profil_resmi']['name']);
        $upload_dir = 'img/';

        // Geçerli uzantıyı kontrol etme
        $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
        $file_extension = pathinfo($filename, PATHINFO_EXTENSION);

        if (in_array($file_extension, $allowed_extensions)) {
            // Dosya boyutunu kontrol etme
            if ($_FILES['profil_resmi']['size'] <= 800 * 1024) {
                $new_filename = $yonetici_id . '.' . $file_extension;
                $upload_file = $upload_dir . $new_filename;

                if (move_uploaded_file($tmp_name, $upload_file)) {
                    $profil_resmi = $new_filename; // Yeni profil resmini ayarlama
                } else {
                    echo "Dosya yükleme hatası.";
                    exit();
                }
            } else {
                echo "Dosya boyutu 800KB'dan fazla olamaz.";
                exit();
            }
        } else {
            echo "Geçersiz dosya formatı. Sadece JPG, JPEG, PNG ve GIF formatları kabul edilir.";
            exit();
        }
    }

    // Profil güncelleme sorgusu
    $sql = "UPDATE Yonetici SET yonetici_adi = ?, eposta = ?, profil_resmi = ? WHERE yonetici_id = ?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$yonetici_adi, $eposta, $profil_resmi, $yonetici_id]);

    if ($result) {
        // Oturum bilgilerini güncelleme
        $_SESSION['yonetici_adi'] = $yonetici_adi;
        $_SESSION['eposta'] = $eposta;
        $_SESSION['profil_resmi'] = '../assets/img/avatars/' . $profil_resmi;

        // Başarılı güncelleme
        header("Location: profil.php");
        exit();
    } else {
        // Güncelleme hatası
        $errorInfo = $stmt->errorInfo();
        echo "Hata: " . $errorInfo[2];
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Profil Ayarları</title>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/vendor/fonts/materialdesignicons.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <h4 class="card-header">Profil Detayları</h4>
                                    <div class="card-body">
                                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                                            <img src="<?= htmlspecialchars($_SESSION['profil_resmi']) ?>" alt="user-avatar" class="d-block w-px-120 h-px-120 rounded" id="uploadedAvatar" />
                                            <div class="button-wrapper">
                                                <form id="formAccountSettings" method="POST" enctype="multipart/form-data">
                                                    <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                                                        <span class="d-none d-sm-block">Fotoğraf Yükle</span>
                                                        <i class="mdi mdi-tray-arrow-up d-block d-sm-none"></i>
                                                        <input type="file" id="upload" class="account-file-input" name="profil_resmi" hidden accept="image/png, image/jpeg" />
                                                    </label>
                                                    
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pt-2 mt-1">
                                        <form id="formAccountSettings" method="POST" enctype="multipart/form-data">
                                            <div class="row mt-2 gy-4">
                                                <div class="col-md-6">
                                                    <div class="form-floating form-floating-outline">
                                                        <input class="form-control" type="text" id="yoneticiAdi" name="yoneticiAdi" value="<?= htmlspecialchars($_SESSION['yonetici_adi']) ?>" autofocus />
                                                        <label for="yoneticiAdi">Yönetici Adı</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating form-floating-outline">
                                                        <input class="form-control" type="text" id="eposta" name="eposta" value="<?= htmlspecialchars($_SESSION['eposta']) ?>" placeholder="john.doe@example.com" />
                                                        <label for="eposta">E-posta</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <button type="submit" class="btn btn-primary me-2">Değişiklikleri Kaydet</button>
                                                <button type="reset" class="btn btn-outline-secondary">Sıfırla</button>
                                            </div>
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
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/pages-account-settings-account.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>
</html>
