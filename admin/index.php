<?php
session_start();
require '../config.php';
require '../inc/functions.php';
require '../vendor/autoload.php';
$pterodactyl = new \HCGCloud\Pterodactyl\Pterodactyl($apikey, $pterodomain);
if( checklogin() == true ) {
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
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Vex Panel</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../../index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->


      <!-- Messages Dropdown Menu -->

      <!-- Notifications Dropdown Menu -->

    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
      <img src="../assets/dist/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Vex Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="https://cdn.discordapp.com/avatars/<?php echo $user->id . "/" . $user->avatar ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $user->username ?></a>
          <span class="right badge badge-success"><?php echo $coins ?> Coins</span>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="../" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard
                <!---<span class="right badge badge-danger">New</span>-->
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../order.php" class="nav-link">
              <i class="nav-icon fas fa-money-check-alt"></i>
              <p>
                Order
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../idle.php" class="nav-link">
              <i class="nav-icon fas fa-moon"></i>
              <p>
                Idle
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <?php
          $staffcheck = $conn->query("SELECT * FROM staff WHERE discord_id='".mysqli_real_escape_string($conn, $user->id)."'");
          if($staffcheck->num_rows == 1 ){
            echo '          <li class="nav-item">
            <a href="./admin" class="nav-link active">
              <i class="nav-icon fas fa-lock"></i>
              <p>
                Staff Panel
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>';
          echo '          <li class="nav-item">
          <a href="./resources.php" class="nav-link">
            <i class="nav-icon fas fa-lock"></i>
            <p>
              Add Resources
              <span class="right badge badge-danger">New</span>
            </p>
          </a>
        </li>';
          }
          ?>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">See all your users!</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Username</th>
                    <th>Discord ID</th>
                    <th>Coins</th>
                    <th>Minutes Idled</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
$results = mysqli_query($conn, "SELECT * FROM users");
if( $results->num_rows !== 0 ) {
   while($rowitem = mysqli_fetch_array($results)) {
    $server = $pterodactyl->servers();
    echo "<tr>";
    echo "<td>" . htmlspecialchars($rowitem['discord_user']) . "</td>";
    echo "<td>" . htmlspecialchars($rowitem['discord_id']) . "</td>";
    echo "<td>" . htmlspecialchars($rowitem['coins']) . "</td>";
    echo "<td>" . htmlspecialchars($rowitem['minutes_idle']) . "</td>";
    echo "</tr>";
  }}else{
      echo '<p><b>Seems you have no users yet!</b></p>';
  }
?>
                  </tbody>
                  <tfoot>
                  <tr>
                  <th>Username</th>
                    <th>Discord ID</th>
                    <th>Coins</th>
                    <th>Minutes Idled</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
 
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> <?php echo $version ?>
    </div>
    <strong>Copyright &copy; 2020 <a href="https://discord.gg/S28W5fuCVt">Gallear Technologies</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="../../assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../assets/plugins/jszip/jszip.min.js"></script>
<script src="../../assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="../../assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../assets/dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
