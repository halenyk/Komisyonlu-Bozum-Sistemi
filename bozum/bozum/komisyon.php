<?php
session_start();
if (!isset($_SESSION['yonetici_id'])) {
    header("Location: giris.php");
    exit();
}

include 'ayar.php';
try {
    $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    );

    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("Veritabanına bağlantı hatası: " . $e->getMessage());
}

try {
    $sql = "SELECT * FROM KomisyonOranlari";
    $stmt = $pdo->query($sql);

    $komisyonOranlari = [];
    while ($row = $stmt->fetch()) {
        $komisyonOranlari[] = $row;
    }
} catch (PDOException $e) {
    die("Veri çekme hatası: " . $e->getMessage());
}

$pdo = null;
?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Komisyon İşlemleri</title>
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
                <?php include 'navbar.php' ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row gy-4">
                            <div class="col-12">
                                <?php if (isset($_GET['success'])): ?>
                                    <?php if ($_GET['success'] == 1): ?>
                                        <div id="success-alert" class="alert alert-success" role="alert">
                                            İşlem başarıyla gerçekleştirildi.
                                        </div>
                                    <?php elseif ($_GET['success'] == 2): ?>
                                        <div id="success-alert" class="alert alert-success" role="alert">
                                            Kayıt başarıyla güncellendi.
                                        </div>
                                    <?php else: ?>
                                        <div id="success-alert" class="alert alert-danger" role="alert">
                                            İşlem sırasında bir hata oluştu.
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <div class="d-flex justify-content-start mb-3">
                                    <a href="komisyon_ekle.php" class="btn btn-success me-2">+ KOMİSYON EKLE</a>
                                    <a href="komisyon_csv.php" class="btn btn-primary">CSV İNDİR</a>
                                </div>
                                <div class="card">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="text-truncate">Alt Sınır</th>
                                                    <th class="text-truncate">Üst Sınır</th>
                                                    <th class="text-truncate">Komisyon Oranı</th>
                                                    <th class="text-truncate">İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($komisyonOranlari as $oran): ?>
                                                    <tr>
                                                        <td class="text-truncate"><?= htmlspecialchars($oran['alt_sinir']) ?></td>
                                                        <td class="text-truncate"><?= htmlspecialchars($oran['ust_sinir']) ?></td>
                                                        <td class="text-truncate"><?= '%' . htmlspecialchars($oran['komisyon_orani']) ?></td>
                                                        <td class="text-truncate">
                                                            <a href="komisyon_edit.php?id=<?= $oran['komisyon_id'] ?>" class="btn btn-sm btn-primary">Düzenle</a>
                                                            <button class="btn btn-sm btn-danger btn-delete" data-id="<?= $oran['komisyon_id'] ?>">Sil</button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
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
        $(document).ready(function() {
           
            $(document).on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                if (confirm('Bu kaydı silmek istediğinizden emin misiniz?')) {
                    $.ajax({
                        url: 'komisyondelete.php',
                        type: 'POST',
                        data: { id: id },
                        success: function(response) {
                            if (response === 'success') {
                                var url = new URL(window.location.href);
                                url.searchParams.set('success', 1);
                                window.location.href = url.toString();
                            } else {
                                alert('Kayıt silinemedi: ' + response);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', status, error);
                            alert('AJAX request failed: ' + status + ' - ' + error);
                        }
                    });
                }
            });

            setTimeout(function() {
                $('#success-alert').fadeOut('slow');
                var url = new URL(window.location.href);
                url.searchParams.delete('success');
                window.history.replaceState({}, document.title, url.toString());
            }, 3000); 
        });
    </script>
</body>
</html>
