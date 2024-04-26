<?php
session_start();
include('db_connection.php');

// Check if the user is logged in
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Fetch the student_id for the current user
    $sql5 = "SELECT student_id FROM students WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql5);
    mysqli_stmt_bind_param($stmt, "s", $email);

    if (!mysqli_stmt_execute($stmt)) {
        die("Error fetching student ID: " . mysqli_error($conn));
    }

    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        die("Student ID not found for the current user");
    }

    $_SESSION['student_id'] = $row['student_id'];
    print_r($_SESSION);


    mysqli_stmt_close($stmt);
}

?>



