<?php
session_start();
$page = "";
include "../../connect.php";
$_SESSION['seller_id'];
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
             $seller_id = $_SESSION['seller_id'];

             if ($seller_id) {
                 $query = "SELECT seller_name FROM seller WHERE seller_id = $seller_id";
             
                 $result = mysqli_query($db, $query);
             
                 if ($result && mysqli_num_rows($result) > 0) {
                     $row = mysqli_fetch_assoc($result);
                     $seller_name = $row['seller_name'];
             
                     echo $seller_name;
                 } else {
                     echo 'Seller not found.';
                 }
             } else {
                 echo '<a href="seller-login.php">Login</a>';
             }
                                                        ?>
          </div>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-title">Logged in Succesful</div>
            <a href="seller-profile.php" class="dropdown-item has-icon">
              <i class="far fa-user"></i> Profile
            </a>
            <div class="dropdown-divider"></div>
            <a href="logout.php" class="dropdown-item has-icon text-danger">
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
          <li><a class="nav-link" href="seller-dashboard.php"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>


          <li class="menu-header">Pages</li>
          <li><a class="nav-link" href="seller-addproduct.php"><i class="fas fa-plus"></i> <span>Add Product</span></a></li>
          <li><a class="nav-link" href="seller-showproduct.php"><i class="fas fa-pencil-ruler"></i><span>List of Product</span></a></li>
          <li><a class="nav-link" href="seller-order.php"><i class="fas fa-rocket"></i> <span>Orders</span></a></li>
          <li><a class="nav-link" href="seller-contact.php"><i class="fas fa-bolt"></i> <span>Contact Us</span></a></li>
          <li><a class="nav-link" href="seller-profile.php"><i class="far fa-user"></i> <span>Profile</span></a></li>
      </aside>
    </div>