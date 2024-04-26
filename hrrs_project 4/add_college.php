<?php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the form data
  $collegeName = $_POST['collegeName'];
  $collegeDomain = $_POST['collegeDomain'];
  $collegeLocation = $_POST['collegeLocation'];
  $collegeContactNumber = $_POST['collegeContactNumber'];

  // Insert the form data into the Colleges table
  $sql = "INSERT INTO Colleges (college_name, college_domain, college_location, college_contact_number) 
          VALUES ('$collegeName', '$collegeDomain', '$collegeLocation', '$collegeContactNumber')";

  if (mysqli_query($conn, $sql)) {
    header ("Location:fetch_colleges.php");
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }

  mysqli_close($conn);
}
?>
