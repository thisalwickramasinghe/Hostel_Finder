<?php
session_start();
include_once('connection.php');

// Add Property Form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind parameters
    $stmt = $conn->prepare("INSERT INTO hostel_details (name, image, description, latitude, longitude, rental,seats) VALUES (?, ?, ?, ?, ?, ?,?)");
    $stmt->bind_param("sssssss", $propertyName, $propertyImage, $propertyDescription, $propertyLatitude, $propertyLongitude, $propertyRental,$propertySeat);

    // Set parameters
    $propertyName = $_POST['propertyName'];
    $propertyImage = $_FILES['propertyImage']['name']; // File name of the uploaded image
    $propertyDescription = $_POST['propertyDescription'];
    $propertyLatitude = $_POST['propertyLatitude'];
    $propertyLongitude = $_POST['propertyLongitude'];
    $propertyRental = $_POST['propertyRental'];
    $propertySeat = $_POST['propertySeat'];

    // Upload image file to server
    $target_dir = "uploads/"; // Directory where uploaded images will be saved
    $target_file = $target_dir . basename($_FILES["propertyImage"]["name"]);
    move_uploaded_file($_FILES["propertyImage"]["tmp_name"], $target_file);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>alert('New record created successfully');</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Fetch approved hostels
$sql_approved = "SELECT name FROM hostel_details WHERE approval_status = 'pending'";
$result_approved = $conn->query($sql_approved);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostel Owner's Page</title>
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
            background-color: #333; /* Dark gray background */
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            margin-bottom: 20px;
        }
        #abc h1 {
            color: #fff; /* White text color */
            text-align: center;
            font-size: 28px; /* Larger font size */
            text-transform: uppercase; /* Uppercase text */
            letter-spacing: 2px; /* Increased letter spacing for elegance */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8); /* Soft text shadow for depth */
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
            background-color: #0a0b59;
            color: rgb(243, 236, 236);
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #365ee1;
        }
        .form-group {
            margin-bottom: 10px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-group input[type="text"] {
            width: 98%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <div id="abc"><h1><b>ADD YOUR HOSTEL ADVERTISEMENT</b></h1></div>

    <!-- Add Property Form -->
    <div id="addPropertyForm" style="display: block;">
        <h2>Enter Hostel Info </h2>
        <form id="propertyForm" enctype="multipart/form-data" method="post">
            <div class="form-group">
                <label for="propertyName">Hostel Address </label>
                <input type="text" id="propertyName" name="propertyName" required>
            </div>
            <div class="form-group">
                <label for="propertyImage">Hostel Image</label>
                <input type="file" id="propertyImage" name="propertyImage" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="propertyDescription">About Hostel </label>
                <input type="text" id="propertyDescription" name="propertyDescription" required>
            </div>
            <div class="form-group">
                <label for="propertyLatitude">Latitude</label>
                <input type="text" id="propertyLatitude" name="propertyLatitude" required>
            </div>
            <div class="form-group">
                <label for="propertyLongitude">Longitude</label>
                <input type="text" id="propertyLongitude" name="propertyLongitude" required>
            </div>
            <div class="form-group">
                <label for="propertyRental">Rental Price</label>
                <input type="text" id="propertyRental" name="propertyRental" required>
            </div>
            <div class="form-group">
                <label for="propertySeat">Number of Seats Available</label>
                <input type="number" id="propertySeat" name="propertySeat" required>
            </div>
            <button type="submit" class="btn">Add Your Hostel</button>
            <button id="logoutBtn" class="btn" onclick="confirmLogout()">Logout</button>
        </form>
    </div>

    <!-- Button to filter approved hostels -->
    <p>
    <form action="" method="post">
        <label for="filterApproved">Approved Hostels:</label>
        <select name="filterApproved" id="filterApproved">
            <option value="all"></option>
            <?php
            if ($result_approved->num_rows > 0) {
                while($row = $result_approved->fetch_assoc()) {
                    echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                }
            }
            ?>
        </select>
     
    </form>
          </p>

    <!-- List of properties -->
    <ul id="propertyList" class="property-list">
        <!-- Property items will be added dynamically here -->
    </ul>
</div>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
<script>
    function confirmLogout() {
        if (confirm("Are you sure you want to logout?")) {
            // Redirect to the logout page
            window.location.href = "index.html";
        }
    }
</script>

