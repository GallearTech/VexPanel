<?php
session_start();
require '../config.php';
require '../inc/functions.php';
require '../vendor/autoload.php';
$pterodactyl = new \HCGCloud\Pterodactyl\Pterodactyl($apikey, $pterodomain);
if(isset($_SESSION['loggedin']) == true) {
  $user = $_SESSION['discord_user'];

  $pterodactyl_panelinfo = $conn->query("SELECT * FROM users WHERE discord_id='" . mysqli_real_escape_string($conn, $user->id) . "'")->fetch_assoc();
    $coins = $pterodactyl_panelinfo['coins'];
}else{
  header("location: ../login.php");
}
$staffcheck = $conn->query("SELECT * FROM staff WHERE discord_id='".mysqli_real_escape_string($conn, $user->id)."'");
if($staffcheck->num_rows == 0 ){
header("location: ../");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $siteName ?></title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../../assets/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../../assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="../../assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../../assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="../../assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../../assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="../../assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <p class="mb-0 font-weight-normal text-large mb-sm-0"> <?php echo $siteName ?></p>
        </div>
        <ul class="nav">
          <li class="nav-item profile">
            <div class="profile-desc">
              <div class="profile-pic">
                <div class="count-indicator">
                  <img class="img-xs rounded-circle " src="https://cdn.discordapp.com/avatars/<?php echo $user->id . "/" . $user->avatar ?>" alt="">
                  <span class="count bg-success"></span>
                </div>
                <div class="profile-name">
                  <h5 class="mb-0 font-weight-normal"><?php echo $user->username ?></h5>
                  <span><?php echo $coins ?> coins</span>
                </div>
              </div>
              <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
              <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
                <a href="./account.php" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-settings text-primary"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">Account Settings</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-onepassword  text-info"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
                  </div>
                </a>
              </div>
            </div>
          </li>
          <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="../">
              <span class="menu-icon">
                <i class="mdi mdi-view-grid"></i>
              </span>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="../order.php">
              <span class="menu-icon">
                <i class="mdi mdi-cash-usd"></i>
              </span>
              <span class="menu-title">Order</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="../idle.php">
              <span class="menu-icon">
                <i class="fas fa-moon"></i>
              </span>
              <span class="menu-title">Idle</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="./account.php">
              <span class="menu-icon">
                <i class="fas fa-key"></i>
              </span>
              <span class="menu-title">Account</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="../announcements.php">
              <span class="menu-icon">
                <i class="fas fa-bullhorn"></i>
              </span>
              <span class="menu-title">Announcements</span>
            </a>
          </li>
          <?php
          $staffcheck = $conn->query("SELECT * FROM staff WHERE discord_id='".mysqli_real_escape_string($conn, $user->id)."'");
          if($staffcheck->num_rows == 1 ){
            echo '<li class="nav-item menu-items">
            <a class="nav-link" href="../admin">
              <span class="menu-icon">
                <i class="fas fa-lock"></i>
              </span>
              <span class="menu-title">Staff Panel</span>
            </a>
          </li>';
          echo '<li class="nav-item menu-items active">
          <a class="nav-link" href="./resources.php">
            <span class="menu-icon">
              <i class="nav-icon fas fa-lock"></i>
            </span>
            <span class="menu-title">Resources</span>
          </a>
        </li>';
        echo '<li class="nav-item menu-items">
        <a class="nav-link" href="./product.php">
          <span class="menu-icon">
            <i class="mdi mdi-cash-usd"></i>
          </span>
          <span class="menu-title">Add Products</span>
        </a>
      </li>';
          }
          ?>
        </ul>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar p-0 fixed-top d-flex flex-row">
          <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
            <a class="navbar-brand brand-logo-mini" href="index.html"><img src="../../assets/images/logo-mini.svg" alt="logo" /></a>
          </div>
          <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-menu"></span>
            </button>
            <ul class="navbar-nav navbar-nav-right">

            
              <li class="nav-item dropdown">
                <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                  <div class="navbar-profile">
                    <img class="img-xs rounded-circle" src="https://cdn.discordapp.com/avatars/<?php echo $user->id . "/" . $user->avatar ?>" alt="">
                    <p class="mb-0 d-none d-sm-block navbar-profile-name"><?php echo $user->username ?></p>
                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                  <h6 class="p-3 mb-0">Profile</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-settings text-success"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Settings</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="../logout.php" class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-logout text-danger"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Logout</p>
                    </div>
                  </a>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-format-line-spacing"></span>
            </button>
          </div>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <!--<div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card corona-gradient-card">
                  <div class="card-body py-0 px-0 px-sm-3">
                    <div class="row align-items-center">
                      <div class="col-4 col-sm-3 col-xl-2">
                        <img src="assets/images/dashboard/Group126@2x.png" class="gradient-corona-img img-fluid" alt="">
                      </div>
                      <div class="col-5 col-sm-7 col-xl-8 p-0">
                        <h4 class="mb-1 mb-sm-0">Want even more features?</h4>
                        <p class="mb-0 font-weight-normal d-none d-sm-block">Check out our Pro version with 5 unique layouts!</p>
                      </div>
                      <div class="col-3 col-sm-2 col-xl-2 pl-0 text-center">
                        <span>
                          <a href="" target="_blank" class="btn btn-outline-light btn-rounded get-started-btn">Upgrade to PRO</a>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>-->
          <div class="row ">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Set Coins</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                        <form action="../inc/setcoins.php" method="post">
                        <div class="card-body">
                      <div class="form-group">
                      <label for="coins">Amount Of Coins</label>
                      <input type="number" class="form-control" id="coins" name="coins" placeholder="Amount Of Coins">
                      </div>
                      <div class="form-group">
                      <label for="did">Users Discord ID</label>
                      <input type="number" class="form-control" id="did" name="did" placeholder="Discord ID">
                      </div>
                      <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </form>
                  </div>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <div class="row ">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Add Coins [IN BETA]</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                        <form action="../inc/addcoins.php" method="post">
                        <div class="card-body">
                      <div class="form-group">
                      <label for="coins">Amount Of Coins</label>
                      <input type="number" class="form-control" id="coins" name="coins" placeholder="Amount Of Coins">
                      </div>
                      <div class="form-group">
                      <label for="did">Users Discord ID</label>
                      <input type="number" class="form-control" id="did" name="did" placeholder="Discord ID">
                      </div>
                      <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </form>
                  </div>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <strong><span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2021 <a href="https://discord.gg/JpZmtYRWYN">Gallear Technologies.</a></strong></span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> <b>Version</b> <?php echo $version ?></span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="../../assets/vendors/chart.js/Chart.min.js"></script>
    <script src="../../assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="../../assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="../../assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="../../assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../../assets/js/off-canvas.js"></script>
    <script src="../../assets/js/hoverable-collapse.js"></script>
    <script src="../../assets/js/misc.js"></script>
    <script src="../../assets/js/settings.js"></script>
    <script src="../../assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="../../assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->
  </body>
</html>