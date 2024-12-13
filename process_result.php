<?php
session_start();
require_once 'connection.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($link, $_POST["username"]);
    $score = $_SESSION['score'];


    // Check if username already exists
    $check_query = "SELECT * FROM users WHERE name = ?";
    $stmt = mysqli_prepare($link, $check_query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) > 0){
        //Username already exists, update score instead of creating new user
        $update_query = "UPDATE users SET score = ? WHERE name = ?";
        $stmt = mysqli_prepare($link, $update_query);
        mysqli_stmt_bind_param($stmt, "is", $score, $username);
    } else {
        //Insert new user
        $insert_query = "INSERT INTO users (name, score) VALUES (?, ?)";
        $stmt = mysqli_prepare($link, $insert_query);
        mysqli_stmt_bind_param($stmt, "si", $username, $score);
    }

    if (mysqli_stmt_execute($stmt)) {
        echo "<p>Score saved successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error saving score: " . mysqli_error($link) . "</p>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);
    session_unset();
    session_destroy();

} else {
  echo "<p>Invalid request</p>";
}
?>
<a href="demo.php">Try again</a>