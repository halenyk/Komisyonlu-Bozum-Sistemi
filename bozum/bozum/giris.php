<?php
session_start();
include 'ayar.php'; 

$hata = ''; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $eposta = $_POST['eposta'];
    $sifre = $_POST['sifre'];

    $stmt = $pdo->prepare("SELECT * FROM Yonetici WHERE eposta = :eposta");
    $stmt->execute(['eposta' => $eposta]);
    $yonetici = $stmt->fetch();

    if ($yonetici && $yonetici['sifre'] === $sifre) {
      
        $_SESSION['yonetici_id'] = $yonetici['yonetici_id'];
        $_SESSION['yonetici_adi'] = $yonetici['yonetici_adi'];
        header("Location: index.php");
        exit();
    } else {
        $hata = "Geçersiz e-posta veya şifre.";
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Yönetici Girişi</title>
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
    <link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />
    <script src="../assets/vendor/js/helpers.js"></script>
    <script src="../assets/js/config.js"></script>
</head>
<body>
    <div class="position-relative">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
          <div class="card p-2">
            <div class="app-brand justify-content-center mt-5">
              <a href="giris.php" class="app-brand-link gap-2">
                <span class="app-brand-logo demo">
                  <span style="color: #9055fd">
                    <!-- SVG LOGO -->
                  </span>
                </span>
                <span class="app-brand-text demo text-heading fw-semibold">Bozum</span>
              </a>
            </div>
            <div class="card-body mt-2">
              <h4 class="mb-2">Hoşgeldin,Yönetici</h4>
              <p class="mb-4">Lütfen giriş yapınız</p>

              <?php if ($hata): ?>
                <p style="color: red;"><?php echo $hata; ?></p>
              <?php endif; ?>

              <form id="formAuthentication" class="mb-3" method="POST">
                <div class="form-floating form-floating-outline mb-3">
                  <input type="email" class="form-control" id="eposta" name="eposta" placeholder="E-posta adresiniz" autofocus required />
                  <label for="eposta">E-Posta</label>
                </div>
                <div class="mb-3">
                  <div class="form-password-toggle">
                    <div class="input-group input-group-merge">
                      <div class="form-floating form-floating-outline">
                        <input type="password" id="sifre" class="form-control" name="sifre" placeholder="••••••••••••" aria-describedby="password" required />
                        <label for="sifre">Şifre</label>
                      </div>
                      <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                    </div>
                  </div>
                </div>
                <div class="mb-3 d-flex justify-content-between">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember-me" />
                    <label class="form-check-label" for="remember-me"> Beni Hatırla</label>
                  </div>
                  <a href="auth-forgot-password-basic.html" class="float-end mb-1">
                 
                  </a>
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit">Giriş Yap</button>
                </div>
              </form>

           

  

    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>
    <script src="../assets/js/main.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>
</html>
