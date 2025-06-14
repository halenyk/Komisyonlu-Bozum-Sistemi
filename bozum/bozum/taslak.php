<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed layout-compact"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Dashboard - Analytics | Materio - Bootstrap Material Design Admin Template</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
      rel="stylesheet" />

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

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="mdi mdi-menu mdi-24px"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- Place this tag where you want the button to render. -->
                            <li class="nav-item lh-1 me-3">
                                <a class="github-button" href="https://github.com/themeselection/materio-bootstrap-html-admin-template-free" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star themeselection/materio-bootstrap-html-admin-template-free on GitHub">Star</a>
                            </li>

                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end mt-3 py-2">
                                    <li>
                                        <a class="dropdown-item pb-2 mb-1" href="#">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2 pe-1">
                                                    <div class="avatar avatar-online">
                                                        <img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">John Doe</h6>
                                                    <small class="text-muted">Admin</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider my-1"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="../yeni/profile.php">
                                            <i class="mdi mdi-account-outline me-1 mdi-20px"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="../yeni/.php">
                                            <i class="mdi mdi-cog-outline me-1 mdi-20px"></i>
                                            <span class="align-middle">Settings</span>
                                        </a>
                                    </li>
                                    
                                 
                                    <li>
                                        <div class="dropdown-divider my-1"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);">
                                            <i class="mdi mdi-power me-1 mdi-20px"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>

                <!-- / Navbar -->
            
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
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
                            <th class="text-truncate">Email</th>
                            <th class="text-truncate">Age</th>
                            <th class="text-truncate">Salary</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="text-truncate">Jordan Stevenson</td>
                            <td class="text-truncate">Stevenson</td>
                            <td class="text-truncate">susanna.Lind57@gmail.com</td>
                            <td class="text-truncate">24</td>
                            <td class="text-truncate">34500$</td>
                          </tr>
                          <tr>
                            <td class="text-truncate">Benedetto Rossiter</td>
                            <td class="text-truncate">Rossiter</td>
                            <td class="text-truncate">estelle.Bailey10@gmail.com</td>
                            <td class="text-truncate">29</td>
                            <td class="text-truncate">64500$</td>
                          </tr>
                          <tr>
                            <td class="text-truncate">Bentlee Emblin</td>
                            <td class="text-truncate">Emblin</td>
                            <td class="text-truncate">milo86@hotmail.com</td>
                            <td class="text-truncate">44</td>
                            <td class="text-truncate">94500$</td>
                          </tr>
                          <tr>
                            <td class="text-truncate">Bertha Biner</td>
                            <td class="text-truncate">Biner</td>
                            <td class="text-truncate">lonnie35@hotmail.com</td>
                            <td class="text-truncate">19</td>
                            <td class="text-truncate">4500$</td>
                          </tr>
                          <tr>
                            <td class="text-truncate">Beverlie Krabbe</td>
                            <td class="text-truncate">Krabbe</td>
                            <td class="text-truncate">ahmad_Collins@yahoo.com</td>
                            <td class="text-truncate">22</td>
                            <td class="text-truncate">10500$</td>
                          </tr>
                          <tr>
                            <td class="text-truncate">Bradan Rosebotham</td>
                            <td class="text-truncate">Rosebotham</td>
                            <td class="text-truncate">tillman.Gleason68@hotmail.com</td>
                            <td class="text-truncate">50</td>
                            <td class="text-truncate">99500$</td>
                          </tr>
                          <tr>
                            <td class="text-truncate">Bree Kilday</td>
                            <td class="text-truncate">Kilday</td>
                            <td class="text-truncate">otho21@gmail.com</td>
                            <td class="text-truncate">23</td>
                            <td class="text-truncate">23500$</td>
                          </tr>
                          <tr>
                            <td class="text-truncate">Breena Gallemore</td>
                            <td class="text-truncate">Gallemore</td>
                            <td class="text-truncate">florencio.Little@hotmail.com</td>
                            <td class="text-truncate">33</td>
                            <td class="text-truncate">20500$</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <!--/ Data Tables -->
              </div>
            </div>
            <!-- / Content -->


    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
