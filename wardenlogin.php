<?php
session_start();
include_once('connection.php');


// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieving username and password from the form
    $username = $_POST['username']; // Assuming 'w_name' is the column name for the username field
    $password = $_POST['password']; // Assuming 'w_password' is the column name for the password field

    // Query to check if the user exists in the database
    $query = "SELECT * FROM warden WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        // If user exists, redirect to a welcome page
        header("Location: wdash.php ");
        exit();
    } else {
        // If user does not exist, show an error message
        echo "Invalid username or password!";
    }
}

// Closing the connection
mysqli_close($conn);
?>
