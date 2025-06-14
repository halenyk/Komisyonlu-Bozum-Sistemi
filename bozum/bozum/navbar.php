<?php

include 'ayar.php';

try {
    $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    );

    $pdo = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT yonetici_adi, profil_resmi FROM Yonetici WHERE yonetici_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['yonetici_id']]);
    $yonetici = $stmt->fetch();

    if ($yonetici) {
        $_SESSION['yonetici_adi'] = $yonetici['yonetici_adi'];
        $_SESSION['profil_resmi'] = $yonetici['profil_resmi'];
    } else {
        echo "Yönetici bilgileri bulunamadı.";
        exit();
    }
} catch (PDOException $e) {
    die("Veritabanına bağlantı hatası: " . $e->getMessage());
}

$pdo = null;
?>

<!-- Navbar -->
<nav class="layout-navbar navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="mdi mdi-menu mdi-24px"></i>
        </a>
    </div>
    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="<?= htmlspecialchars($_SESSION['profil_resmi']) ?>" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end mt-3 py-2">
                    <li>
                        <a class="dropdown-item pb-2 mb-1" href="#">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-2 pe-1">
                                    <div class="avatar avatar-online">
                                        <img src="<?= htmlspecialchars($_SESSION['profil_resmi']) ?>" alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0"><?php echo htmlspecialchars($_SESSION['yonetici_adi']); ?></h6>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="profil.php">
                            <i class="mdi mdi-account-outline me-1 mdi-20px"></i>
                            <span class="align-middle">Profilim</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="ayarlar.php">
                            <i class="mdi mdi-cog-outline me-1 mdi-20px"></i>
                            <span class="align-middle">Ayarlar</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="cikis.php">
                            <i class="mdi mdi-power me-1 mdi-20px"></i>
                            <span class="align-middle">Çıkış</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<!-- / Navbar -->
