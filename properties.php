<?php
session_start();
include_once('connection.php');

// Fetch approved hostels
$sql_approved = "SELECT hostel_id,name,image,description,rental,seats FROM hostel_details WHERE approval_status = 'approved' and seats > 0";
$result_approved = $conn->query($sql_approved);
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>Hostel - NSBM Green University</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/hostel.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>

  </head>

<body>

  <!-- ***** Preloader Start ***** -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <!-- ***** Preloader End ***** -->

  <div class="sub-header">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-8">
          <ul class="info">
            <li><i class="fa fa-envelope"></i> NSBMHostels@gmail.com </li>
            <li><i class="fa fa-map"></i> NSBM Green University</li>
          </ul>
        </div>
        <div class="col-lg-4 col-md-4">
          <ul class="social-links">
          
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="index.html" class="logo">
                        <h1>Hostels</h1>
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                      <li><a href="index.php">Home</a></li>
                      <li><a href="properties.php" class="active">Hostels</a></li>
                      
                     
                      <li></li>
                  </ul>   
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->

  <div class="page-heading header-text">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <span class="breadcrumb"><a href="#">Home</a> / Hostels</span>
          <h3>Properties</h3>
        </div>
      </div>
    </div>
  </div>

  <div class="section properties">
    <div class="container">
      <ul class="properties-filter">
        
        
      </ul>
      <div class="row properties-box">
      <?php
            if ($result_approved->num_rows > 0) {
                while($row = $result_approved->fetch_assoc()) {
                    // echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                    echo "<div class='col-lg-4 col-md-6 align-self-center mb-30 properties-items col-md-6 str'>
                    <div class='item'><a href='#'><img src='uploads/" . $row['image'] . "' alt=''></a><h6>Rental Price RS: " . $row['rental'] . "</h6>
                    <h4><a href='#'>Name : </a>" . $row['name'] . "</h4>
                    <ul><li>Description: <span> " . $row['description'] . "</span></li>
                    <ul><li>Seats: <span> " . $row['seats'] . "</span></li>
                    </ul><div class='main-button'>
                    <a href='propertiseupdate.php?id=" . $row['hostel_id'] . "'>Reserve</a>
                    </div></div></div>";
                }
            }
      ?>
        
        
        
        
        
      <div class="row">
        <div class="col-lg-12">
          <ul class="pagination">
           
          </ul>
        </div>
      </div>
    </div>
  </div>

  <footer>
    <div class="container">
      <div class="col-lg-12">
        <p>Copyright © 2024 NSBM Green University Hostel Finding. All rights reserved. 
        
        </p>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/js/isotope.min.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/counter.js"></script>
  <script src="assets/js/custom.js"></script>

  </body>
</html>