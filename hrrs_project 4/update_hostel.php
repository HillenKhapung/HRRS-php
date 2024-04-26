<?php
include('db_connection.php');

if (isset($_GET['id'])) {
    $hostel_id = $_GET['id'];
    $sql = "SELECT * FROM Hostels WHERE hostel_id = $hostel_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        // You can use $row values to pre-fill the form fields for editing
        $hostel_name = $row['hostel_name'];
        $hostel_location = $row['hostel_location'];
        $hostel_contact_number = $row['hostel_contact_number'];
        $hostel_no_of_beds = $row['hostel_no_of_beds'];
        $Price_per_bed = $row['Price_per_bed'];
        $hostel_description = $row['hostel_description'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission for updating hostel information
    $new_name = $_POST['hostelName'];
    $new_location = $_POST['hostelLocation'];
    $new_contact_number = $_POST['hostelContactNumber'];
    $new_no_of_beds = $_POST['hostelNoOfBeds'];
    $new_price_per_bed = $_POST['PricePerBed'];
    $new_description = $_POST['hostelDescription'];

    $update_sql = "UPDATE Hostels 
                   SET
                       hostel_name = '$new_name', 
                       hostel_location = '$new_location', 
                       hostel_contact_number = '$new_contact_number', 
                       hostel_no_of_beds = '$new_no_of_beds', 
                       Price_per_bed = '$new_price_per_bed', 
                       hostel_description = '$new_description'
                   WHERE hostel_id = $hostel_id";

    if (mysqli_query($conn, $update_sql)) {
        // Hostel information updated successfully
        header("Location: fetch_hostels.php"); // Redirect to dashboard or any other page
        exit();
    } else {
        echo "Error updating hostel information: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Hostel</title>
</head>
<body>
    <h2>Edit Hostel</h2>
    <form action="" method="POST">
        <label for="hostelName">Hostel Name:</label>
        <input type="text" id="hostelName" name="hostelName" value="<?php echo $hostel_name; ?>" required><br><br>

        <label for="hostelLocation">Hostel Location:</label>
        <input type="text" id="hostelLocation" name="hostelLocation" value="<?php echo $hostel_location; ?>" required><br><br>

        <label for="hostelContactNumber">Contact Number:</label>
        <input type="text" id="hostelContactNumber" name="hostelContactNumber" value="<?php echo $hostel_contact_number; ?>" required><br><br>

        <label for="hostelNoOfBeds">No. of Beds:</label>
        <input type="text" id="hostelNoOfBeds" name="hostelNoOfBeds" value="<?php echo $hostel_no_of_beds; ?>" required><br><br>

        <label for="PricePerBed">Price per Bed:</label>
        <input type="text" id="PricePerBed" name="PricePerBed" value="<?php echo $Price_per_bed; ?>" required><br><br>

        <label for="hostelDescription">Description:</label>
        <textarea id="hostelDescription" name="hostelDescription" required><?php echo $hostel_description; ?></textarea><br><br>

        <input type="submit" value="Update">
    </form>
</body>
</html>
