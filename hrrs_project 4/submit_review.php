<?php 
    // Connect to the database 
    $db = new mysqli("localhost", "root", "", "hostel_reservation_system"); 
 
    // Get the form data 
    $review = $db->real_escape_string($_POST['review']); 
    $name = $db->real_escape_string($_POST['name']);
 
    // Insert the review into the database 
    $query = "INSERT INTO student_reviews ( review_text,student_name) VALUES ('$review','$name')"; 
    $db->query($query); 
 
    // Redirect the user to the review page 
    header("Location: reviews.php"); 
?>