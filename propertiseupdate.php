<?php
session_start();
include_once('connection.php');

// Get value from the query string
$id = isset($_GET['id']) ? $_GET['id'] : '';

try {
    // Update statement
    $sql = "UPDATE hostel_details set seats = ((SELECT seats from hostel_details where hostel_id =$id) -1 ) where hostel_id = $id"; 
    $conn->query($sql);
    
    echo "Record updated successfully";
} catch(PDOException $e) {
    die("Could not update record: " . $e->getMessage());
}
header('location:properties.php');
?>