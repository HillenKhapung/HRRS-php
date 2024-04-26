<?php
include('db_connection.php');

if (isset($_GET['id'])) {
    $college_id = $_GET['id'];
    $sql = "SELECT * FROM Colleges WHERE college_id = $college_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        // You can use $row values to pre-fill the form fields for editing
        $college_name = $row['college_name'];
        $college_domain = $row['college_domain'];
        $college_location = $row['college_location'];
        $college_contact_number = $row['college_contact_number'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission for updating college information
    $new_name = $_POST['collegeName'];
    $new_domain = $_POST['collegeDomain'];
    $new_location = $_POST['collegeLocation'];
    $new_contact_number = $_POST['collegeContactNumber'];

    $update_sql = "UPDATE Colleges 
                   SET college_name = '$new_name', 
                       college_domain = '$new_domain', 
                       college_location = '$new_location', 
                       college_contact_number = '$new_contact_number'
                   WHERE college_id = $college_id";

    if (mysqli_query($conn, $update_sql)) {
        // College information updated successfully
        header("Location: fetch_colleges.php"); // Redirect to dashboard or any other page
        exit();
    } else {
        echo "Error updating college information: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit College</title>
</head>
<body>
    <h2>Edit College</h2>
    <form action="" method="POST">
        <label for="collegeName">College Name:</label>
        <input type="text" id="collegeName" name="collegeName" value="<?php echo $college_name; ?>" required><br><br>

        <label for="collegeDomain">College Domain:</label>
        <input type="text" id="collegeDomain" name="collegeDomain" value="<?php echo $college_domain; ?>" required><br><br>

        <label for="collegeLocation">College Location:</label>
        <input type="text" id="collegeLocation" name="collegeLocation" value="<?php echo $college_location; ?>" required><br><br>

        <label for="collegeContactNumber">Contact Number:</label>
        <input type="text" id="collegeContactNumber" name="collegeContactNumber" value="<?php echo $college_contact_number; ?>" required><br><br>

        <input type="submit" value="Update">
    </form>
</body>
</html>
