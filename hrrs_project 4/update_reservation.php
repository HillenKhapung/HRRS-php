<?php
include('db_connection.php');

if (isset($_GET['id'])) {
    $reservation_id = $_GET['id'];
    $sql = "SELECT * FROM Reservations WHERE reservation_id = $reservation_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $no_of_beds = $row['no_of_beds'];
        $arrival_date = $row['arrival_date'];
        $departure_date = $row['departure_date'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission for updating reservation information
    $new_no_of_beds = $_POST['noOfBeds'];
    $new_arrival_date = $_POST['arrivalDate'];
    $new_departure_date = $_POST['departureDate'];

    $update_sql = "UPDATE Reservations 
                   SET 
                       no_of_beds = '$new_no_of_beds', 
                       arrival_date = '$new_arrival_date', 
                       departure_date = '$new_departure_date'
                   WHERE reservation_id = $reservation_id";

    if (mysqli_query($conn, $update_sql)) {
        // Reservation information updated successfully
        header("Location: fetch_reservtions.php"); // Redirect to dashboard or any other page
        exit();
    } else {
        echo "Error updating reservation information: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservation</title>
</head>
<body>
    <h2>Edit Reservation</h2>
    <form action="" method="POST">

        <label for="noOfBeds">No. of Beds:</label>
        <input type="text" id="noOfBeds" name="noOfBeds" value="<?php echo $no_of_beds; ?>" required><br><br>

        <label for="arrivalDate">Arrival Date:</label>
        <input type="date" id="arrivalDate" name="arrivalDate" value="<?php echo $arrival_date; ?>" required><br><br>

        <label for="departureDate">Departure Date:</label>
        <input type="date" id="departureDate" name="departureDate" value="<?php echo $departure_date; ?>" required><br><br>

        <input type="submit" value="Update">
    </form>
</body>
</html>
