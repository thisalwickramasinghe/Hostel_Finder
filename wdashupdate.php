<?php
session_start();
include_once('connection.php');

// Get value from the query string
$id = isset($_GET['id']) ? $_GET['id'] : '';
$newValue = isset($_GET['status']) ? $_GET['status'] : '';

try {
    // Update statement
    $sql = "UPDATE hostel_details ". "SET approval_status = '$newValue' ". "WHERE hostel_id = $id" ;
    $conn->query($sql);
    
    echo "Record updated successfully";
} catch(PDOException $e) {
    die("Could not update record: " . $e->getMessage());
}
header('location:wdash.php');
?>