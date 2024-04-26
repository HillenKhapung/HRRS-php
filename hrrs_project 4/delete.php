<?php
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] === "GET") {
  // Validate and sanitize user input
  $table = $_GET["table"];
  $id = $_GET["id"];

  // Validate $table to ensure it is a valid table name
  $validTables = array("Owners", "Students", "Hostels", "Colleges", "Reservations", "Student_Reviews");
  if (!in_array($table, $validTables)) {
    echo"<script>alert('error');</script>";
    exit;
  }

  // Validate $id to ensure it is a valid integer
  if (!ctype_digit($id)) {
    echo"<script>alert('error');</script>";
    exit;
  }

  // Delete the record from the respective table
  if ($table === "Colleges") {
    $deleteCollegeStmt = mysqli_prepare($conn, "DELETE FROM Colleges WHERE college_id = ?");
    mysqli_stmt_bind_param($deleteCollegeStmt, "i", $id);

    if (mysqli_stmt_execute($deleteCollegeStmt)) {
      // Deletion from Colleges table successful
      echo"<script>alert('success');</script>";
      header ("Location:fetch_colleges.php");
    } else {
      // Deletion from Colleges table failed
      echo"<script>alert('error');</script>";
    }

    mysqli_stmt_close($deleteCollegeStmt);
  } else if ($table === "Reservations") {
    $deleteReservationStmt = mysqli_prepare($conn, "DELETE FROM Reservations WHERE reservation_id = ?");
    mysqli_stmt_bind_param($deleteReservationStmt, "i", $id);

    if (mysqli_stmt_execute($deleteReservationStmt)) {
      // Deletion from Reservations table successful
      echo"<script>alert('success');</script>";
      header ("Location:fetch_reservations.php");
    } else {
      // Deletion from Reservations table failed
      echo"<script>alert('error');</script>";
    }

    mysqli_stmt_close($deleteReservationStmt);
  } else if ($table === "Student_Reviews") {
    $deleteReviewStmt = mysqli_prepare($conn, "DELETE FROM Student_Reviews WHERE review_id = ?");
    mysqli_stmt_bind_param($deleteReviewStmt, "i", $id);

    if (mysqli_stmt_execute($deleteReviewStmt)) {
      // Deletion from Student_Reviews table successful
      echo"<script>alert('success');</script>";
      header ("Location:fetch_reviews.php");
    } else {
      // Deletion from Student_Reviews table failed
      echo"<script>alert('error');</script>";
    }

    mysqli_stmt_close($deleteReviewStmt);
  } else {
    // Fetch the email associated with the record
    $email = null;
    if ($table === "Owners") {
      $stmt = mysqli_prepare($conn, "SELECT email FROM Owners WHERE owner_id = ?");
    } elseif ($table === "Students") {
      $stmt = mysqli_prepare($conn, "SELECT email FROM Students WHERE student_id = ?");
    }
    
    if ($stmt) {
      mysqli_stmt_bind_param($stmt, "i", $id);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_bind_result($stmt, $email);
      mysqli_stmt_fetch($stmt);
      mysqli_stmt_close($stmt);
    }

    if ($email) {
      // Delete the corresponding user record from the Users table
      $deleteUserStmt = mysqli_prepare($conn, "DELETE FROM Users WHERE email = ?");
      mysqli_stmt_bind_param($deleteUserStmt, "s", $email);

      if (mysqli_stmt_execute($deleteUserStmt)) {
        // Deletion from Users table successful
        echo"<script>alert('success');</script>";
        header ("Location:fetch_owners.php");
      } else {
        // Deletion from Users table failed
        echo"<script>alert('error');</script>";
      }

      mysqli_stmt_close($deleteUserStmt);
    } else {
      // Email not found
      echo"<script>alert('error');</script>";
    }
  }

  mysqli_close($conn);
}
?>
