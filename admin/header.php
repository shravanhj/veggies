<?php
include '../database/dbconn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">-->
    <link href="../bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Home Page</title>
</head>
<style>
    *{
        letter-spacing: 1px;
    }
    ul{
        font-family: calibri;
    }
    .nav-link{
        color: black;
    }
    .nav-link:hover{
        color: gray;
    }    
    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .closebtn:hover {
        color: grey;
    }
</style>
<body>
  <?php
  if(session_id() == '') {
    session_start();
}
  
  if(isset($_SESSION['admin_id'])){
    echo '
    <div class="navbar justify-content-around" style="background-color: white; box-shadow:0px 1px 5px 0px black;">
    <a class="navbar-brand fs-3 fw-bolder" href="#" style="text-align:left; text-transform:uppercase;">Veggies</a>
<div>
<a class="nav-link" href="logout.php" role="button"><i class="fa fa-sign-out" style="padding-right: 5px;"></i>Logout</a>
</div>
</div>
<nav class="navbar navbar-expand-lg">
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="fa fa-bars outline-0 border-0"></span>
  </button>
    <div class="container-fluid">
    <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
        </li>
        <!-- Dropdown Menu Starts -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Profile</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="dashboard.php">Profile</a></li>
            <li><a class="dropdown-item" href="changePassword.php">Change Password</a></li>
            <li><a class="dropdown-item" href="update.php">Update Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
          </ul>
        </li>
        <!-- Dropdown Menu Ends -->
        <!-- Dropdown Menu Starts -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Products</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="products.php">Products Info</a></li>
            <li><a class="dropdown-item" href="addproduct.php">Add New Product</a></li>
            <li><a class="dropdown-item" href="productids.php">Used Product IDs</a></li>
          </ul>
        </li>
        <!-- Dropdown Menu Ends -->
        <!-- Dropdown Menu Starts -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">e-Shop</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="orders.php">Orders Status</a></li>
            <li><a class="dropdown-item" href="payments.php">Payments Status</a></li>
            <li><a class="dropdown-item" href="list.php">Registered Users</a></li>
          </ul>
        </li>
        <!-- Dropdown Menu Ends -->
        <li class="nav-item">
          <a class="nav-link" href="#about">About Us</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
    ';
  }
  else{
    echo '
    <div class="navbar justify-content-around" style="background-color: white; box-shadow:0px 1px 5px 0px black;">
    <a class="navbar-brand fs-3 fw-bolder" href="#" style="text-align:left; text-transform:uppercase;">Veggies</a>
    <li class="nav-item dropdown" style="list-style-type:none;">
    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><i class="fa fa-user-circle" style="padding-right: 5px;"></i>My Account</a>
    <ul class="dropdown-menu">
      <li><a class="dropdown-item" href="../signup.php">Create Account</a></li>
      <li><a class="dropdown-item" href="../login.php">Login</a></li>
      <li><hr class="dropdown-divider"></li>
      <li><a class="dropdown-item" href="admin/login.php">Admin Login</a></li>
    </ul>
  </li>
</div>
<nav class="navbar navbar-expand-lg">
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="fa fa-bars outline-0 border-0"></span>
  </button>
    <div class="container-fluid">
    <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
        </li>
        <!-- Dropdown Menu Starts -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Categories</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../productpage.php?Product_Category=Vegetables">Vegetables</a></li>
            <li><a class="dropdown-item" href="../productpage.php?Product_Category=Fruits">Fruits</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#about">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#contact">Contact</a>
        </li>
        <!-- Dropdown Menu Ends -->
      </ul>
    </div>
  </div>
</nav>
    ';
  }
  ?>