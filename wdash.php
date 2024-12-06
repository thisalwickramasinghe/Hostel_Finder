<?php
session_start();
include_once('connection.php');

// Fetch approved hostels
$sql_approved = "SELECT hostel_id,name,image,description,rental FROM hostel_details WHERE approval_status = 'pending'";
$result_approved = $conn->query($sql_approved);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Landlord Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-image: url("92.jpg");
      background-size: cover;
      background-position: center;
    }
    .container {
      max-width: 900px;
      margin: 20px auto;
      padding: 20px;
      background-color: rgba(184, 187, 194, 0.8);
      border-radius: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    #abc {
      width: 93%;
      padding: 20px;
      background-color: #333;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
      margin-bottom: 20px;
    }
    #abc h1 {
      color: #fff;
      text-align: center;
      font-size: 28px;
      text-transform: uppercase;
      letter-spacing: 2px;
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
    }
    h1 {
      text-align: center;
      color: #fefcfc;
    }
    .property-list {
      list-style-type: none;
      padding: 0;
    }
    .property-item {
      border: 1px solid #ccc;
      border-radius: 5px;
      margin-bottom: 10px;
      padding: 10px;
      background-color: #e6dcdc;
    }
    .property-item img {
      width: 200px; 
      height: 150px; 
      border-radius: 5px;
      margin-bottom: 10px;
    }
    .btn {
      padding: 10px 20px;
      margin-right: 5px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    .btn-accept {
      background-color: #7cffb2; /* Light green color */
      color: rgb(0, 0, 0); /* Black text color */
    }
    .btn-reject {
      background-color: #ff0000;
      color: rgb(243, 236, 236);
    }
    .btn-notify {
      background-color: #7cffb2; /* Light green color */
      color: rgb(0, 0, 0); /* Black text color */
    }
    .btn:hover {
      background-color: #365ee1;
    }
    #map {
      height: 400px;
      width: 100%;
      margin-bottom: 20px;
    }
    .btn-view-map {
  background-color: #7cffb2; /* Light green color */
  color: #2c0eeb; /* Black text color */
  border: 10px;
  border-radius: 50px;
  padding: 50px 75px;
  margin-bottom: 20px; /* Adjust margin as needed */
  cursor: pointer;
  transition: background-color 0.5s;
}

.btn-view-map:hover {
  background-color: #6bc99d; /* Darker shade of green on hover */
}
  </style>
</head>
<body>

<div class="container">
  <div id="abc"><h1><b>  Requests</b></h1></div>
  <center><a href="map.html"><button class="btn-view-map"><b>View Places on the Map</b></button></a></center>
  <ul id="boardingList" class="property-list">
  <?php
            if ($result_approved->num_rows > 0) {
                while($row = $result_approved->fetch_assoc()) {
                  echo "<li class='property-item'>
         <h3>". $row['name'] ."</h3>
        <img src='uploads/" . $row['image'] . "' alt='John Doe'>
        <p><strong>Description:</strong> " . $row['description'] . "</p>
        
        <p><strong>Rental:</strong>  " . $row['rental'] . "</p>
        
        <a href='wdashupdate.php?id=" . $row['hostel_id'] . "&status=approved'>Approve</a>
        <a href='wdashupdate.php?id=" . $row['hostel_id'] . "&status=rejected'>Reject</a>

      </li>";
    }
  }
?>
  </ul>
  

<script>

  // Initialize and add the map
  function initMap() {
    // The location of the center of the map
    var centerMap = { lat: 40.7128, lng: -74.0060 }; // New York
    var map = new google.maps.Map(document.getElementById("map"), {
      zoom: 10,
      center: centerMap,
    });

    // Markers for each boarding request
    boardingRequests.forEach(function(request, index) {
      var geocoder = new google.maps.Geocoder();
      geocodeAddress(geocoder, map, request);
    });
  }

  function geocodeAddress(geocoder, resultsMap, request) {
    geocoder.geocode({ address: request.location }, function(results, status) {
      if (status === "OK") {
        var marker = new google.maps.Marker({
          map: resultsMap,
          position: results[0].geometry.location,
          title: request.name
        });

        var infoWindow = new google.maps.InfoWindow({
          content: `
            <h3>${request.name}</h3>
            <p><strong>Description:</strong> ${request.description}</p>
            <p><strong>Location:</strong> ${request.location}</p>
            <p><strong>Rental:</strong> ${request.rental}</p>
          `
        });

        marker.addListener("click", function() {
          infoWindow.open(map, marker);
        });
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
  }
</script> 