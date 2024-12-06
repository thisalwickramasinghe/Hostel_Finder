<?php
// Include database connection file
include_once 'connection.php';

// Fetch hostel details from the database
$sql = "SELECT * FROM hostel_details";
$result = $conn->query($sql);
$hostels = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $hostels[] = $row;
    }
}

// Close database connection
$conn->close();

// Return hostel details as JSON
header('Content-Type: application/json');
echo json_encode($hostels);
?>
