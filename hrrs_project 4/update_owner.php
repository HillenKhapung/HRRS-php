<?php
include('db_connection.php');

if (isset($_GET['id'])) {
    $owner_id = $_GET['id'];
    $sql = "SELECT * FROM Owners WHERE owner_id = $owner_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        // You can use $row values to pre-fill the form fields for editing
        $email = $row['email'];
        $password = $row['password'];
        $owner_name = $row['owner_name'];
        $owner_address = $row['owner_address'];
        $owner_contact_number = $row['owner_contact_number'];
        $owner_pan_number = $row['owner_pan_number'];
        $owner_citizenship_number = $row['owner_citizenship_number'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission for updating owner information
    $new_email = $_POST['email'];
    $new_password = $_POST['password']; // Fetch the new password from the form
    $new_owner_name = $_POST['ownerName'];
    $new_owner_address = $_POST['ownerAddress'];
    $new_owner_contact_number = $_POST['ownerContactNumber'];
    $new_owner_pan_number = $_POST['ownerPanNumber'];
    $new_owner_citizenship_number = $_POST['ownerCitizenshipNumber'];

    // Hash the provided password using MD5
    $hashedPassword = md5($new_password);

    $update_sql = "UPDATE Owners 
                   SET email = '$new_email', 
                       password = '$hashedPassword', -- Store the hashed password
                       owner_name = '$new_owner_name', 
                       owner_address = '$new_owner_address', 
                       owner_contact_number = '$new_owner_contact_number', 
                       owner_pan_number = '$new_owner_pan_number', 
                       owner_citizenship_number = '$new_owner_citizenship_number'
                   WHERE owner_id = $owner_id";

    if (mysqli_query($conn, $update_sql)) {
        // Owner information updated successfully
        header("Location: fetch_owners.php"); // Redirect to dashboard or any other page
        exit();
    } else {
        echo "Error updating owner information: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Owner</title>
</head>
<body>
    <h2>Edit Owner</h2>
    <form action="" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" value="<?php echo $password; ?>" required><br><br>

        <label for="ownerName">Name:</label>
        <input type="text" id="ownerName" name="ownerName" value="<?php echo $owner_name; ?>" required><br><br>

        <label for="ownerAddress">Address:</label>
        <input type="text" id="ownerAddress" name="ownerAddress" value="<?php echo $owner_address; ?>" required><br><br>

        <label for="ownerContactNumber">Contact Number:</label>
        <input type="text" id="ownerContactNumber" name="ownerContactNumber" value="<?php echo $owner_contact_number; ?>" required><br><br>

        <label for="ownerPanNumber">PAN Number:</label>
        <input type="text" id="ownerPanNumber" name="ownerPanNumber" value="<?php echo $owner_pan_number; ?>" required><br><br>

        <label for="ownerCitizenshipNumber">Citizenship Number:</label>
        <input type="text" id="ownerCitizenshipNumber" name="ownerCitizenshipNumber" value="<?php echo $owner_citizenship_number; ?>" required><br><br>

        <input type="submit" value="Update">
    </form>
</body>
</html>
