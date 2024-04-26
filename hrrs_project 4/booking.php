<?php
session_start();

if ($_SESSION['loggedin'] !== TRUE) {
    header('Location: login.html');
    exit(); // Ensure script stops executing after redirection
}

// Include the database connection file
include('db_connection.php');

$rid = $_POST['rid'];
$student_id = $_SESSION["student_id"];
$hostel_id = $_SESSION["hostel_id"];
$Adate = date('Y-m-d', strtotime($_POST['Adate']));
$Ddate = date('Y-m-d', strtotime($_POST['Ddate']));
$hid = $_POST['hid'];
$nbeds = $_POST['nbeds'];

// Prepare and execute the SQL query
$INSERT = "INSERT INTO reservations (Arrival_date, Departure_date, no_of_beds, student_id, hostel_id) VALUES (?, ?, ?, ?, ?)";
$stm = $conn->prepare($INSERT);
$stm->bind_param("ssiii", $Adate, $Ddate, $nbeds, $student_id, $hostel_id);

if ($stm->execute()) {
    $sql1 = "SELECT * FROM hostels WHERE hostel_id = ?";
    $stmt = $conn->prepare($sql1);
    $stmt->bind_param("i", $hostel_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $hostel_no_of_beds = $row["hostel_no_of_beds"];
        }

        // Update available rooms count
        if($hostel_no_of_beds==0){
            die ("no available rooms");
        }else{
        $updatedRooms = $hostel_no_of_beds - 1; // Decrease available rooms by 1
        $updateHostelQuery = "UPDATE hostels SET hostel_no_of_beds = ? WHERE hostel_id = ?";
        $stmt = $conn->prepare($updateHostelQuery);
        $stmt->bind_param("ii", $updatedRooms, $hostel_id);
        $stmt->execute();
        }

        $stmt->close();
        $conn->close();
        header('Location: booked1.php');
        exit();
    } else {
        echo "Hostel not found";
    }
} else {
    echo "Error inserting reservation: " . $stm->error;
}

?>
