<?php
session_start();
$page = "";
include "../../connect.php";
$_SESSION['admin_id'];
?>
<div id="app">

    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
          </ul>
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <div class="d-sm-none d-lg-inline-block">Hi, <?php
$admin_id = $_SESSION['admin_id'];

if ($admin_id) {
    $query = "SELECT admin_id FROM admin WHERE admin_id = $admin_id";
 
    $result = mysqli_query($db, $query);
 
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $admin_id = $row['admin_id'];
 
        echo 'Admin ' . $admin_id;
    } else {
        echo 'Admin not found.';
    }
} else {
    echo '<a href="admin-login.php">Login</a>';
}
?>

            </div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-title">Logged in Succesful</div>
              <div class="dropdown-divider"></div>
              <a href="admin-logout.php" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="seller-dashboard.php">OrgaCare</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="seller-dashboard.php">OGC</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li><a class="nav-link" href="admin-dashboard.php"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>
           
            
            <li class="menu-header">Pages</li>
            <li><a class="nav-link" href="admin-sellerlist.php"><i class="fas fa-pencil-ruler"></i><span>All Seller</span></a></li>
            <li><a class="nav-link" href="admin-userlist.php"><i class="fas fa-user"></i> <span>User List</span></a></li>
            <li><a class="nav-link" href="admin-sellerorder.php"><i class="fas fa-rocket"></i> <span>Order List</span></a></li>        
        </aside>
      </div>
