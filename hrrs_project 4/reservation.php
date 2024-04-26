<?php
session_start();
include('db_connection.php');

// Check if the user is logged in
if (isset($_SESSION["email"])) {
    $email = $_SESSION["email"];

    // Fetch the student_id for the current user
    try{
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

    $_SESSION["student_id"] = $row["student_id"];
    print_r($_SESSION);

    mysqli_stmt_close($stmt);
}catch (Exception $e){
  $error = $e->getMessage();
  echo $error;
}
}

?>
<html>

<form method="get" action="reservation.php">
<div class="wrapper" >

    <div class="content">
            <div class="table-container">
        <table border="1" cellpadding="7px" cellspacing="7px" style="border-collapse: collapse">
          <thead>
            <tr>
              <th>Reservation ID</th>
              <th>Student ID</th>
              <th>Hostel ID</th>
              <th>No. of Beds</th>
              <th>Arrival Date</th>
              <th>Departure Date</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $student_id= $_SESSION["student_id"] ;
          include('student_header.php');
include('db_connection.php');
try{
$sql = "SELECT * FROM reservations where student_id = $student_id";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr id="reservation-row-' . $row['reservation_id'] . '">';
    echo '<td>' . $row['reservation_id'] . '</td>';
    echo '<td>' . $row['student_id'] . '</td>';
    echo '<td>' . $row['hostel_id'] . '</td>';
    echo '<td>' . $row['no_of_beds'] . '</td>';
    echo '<td>' . $row['arrival_date'] . '</td>';
    echo '<td>' . $row['departure_date'] . '</td>';
    echo '</tr>';
  }
} else {
  echo '<tr><td colspan="6">No reservations found in the table.</td></tr>';
}
}catch (Exception $e){
  $error = $e->getMessage();
  echo $error;
}
mysqli_close($conn);
?>

          </tbody>
        </table>
        <input type="submit" name="cancel" value="cancel booking">
      </div>
</div>
</div>
</form>
</html>
<?php
// $hostel_id=1;

// if (isset($_SESSION['email'])) {
//     if ($_SESSION['type'] !== 'student') {
//         echo 'not allowed!!';
//         // header("location :login.php?error=not_allowed");
//     }
// }
// else {
//     echo 'not allowed2!!';
//     header("location: login.php?error=not_allowed");
// }

$conn = mysqli_connect("localhost","root","","hostel_reservation_system");
if(isset($_GET['cancel']))
{
    // Cancel Booking functionality
    if(mysqli_connect_error()){
        die('connect Error('.mysqli_connect_error().')'.mysqli_connect_error());
    }
    $cancelQuery = "DELETE  FROM `reservations` WHERE `student_id` =  $student_id";


    $result = mysqli_query($conn, $cancelQuery);

    // Check if the DELETE query was successful
    if ($result) {
        echo "Row deleted successfully.";
    } else {
        echo "Error deleting row: " . mysqli_error($conn);
    }

    $sql5 = "SELECT *  from `reservations` where `student_id` = $student_id";
    $result = $conn->query($sql5);
    if(mysqli_num_rows($result)>0){
     while($row = $result->fetch_assoc()){
        $hostel_id = $row['hostel_id'];
        
      
    }
 }
    
    // $sql5 = "SELECT *  from `reservations` where `student_id` = $student_id";
    // $query_run = mysqli_query($conn, $sql5);
    // while (isset($query_run["id"])) {
    //     $hostel_id = $query_run["hostel_id"];
    // }
    try{
    $sql1="SELECT * from hostels where hostel_id = $hostel_id";
    $result = $conn->query($sql1);
    if(mysqli_num_rows($result)>0){
     while($row = $result->fetch_assoc()){
    $hostel_no_of_beds = $row["hostel_no_of_beds"];
             }
  }
    
    // $sql1="SELECT * from hostels where hostel_id=$hostel_id";
    // $query_run = mysqli_query($conn, $sql1);
    // $hostel_no_of_beds = $query_run["hostel_no_of_beds"];
    
    
    // Update available rooms count
    $updatedRooms = $hostel_no_of_beds + 1;
    $updateHostelQuery = "UPDATE hostels SET hostel_no_of_beds = '$updatedRooms' WHERE hostel_id = '$hostel_id'";
    mysqli_query($conn, $updateHostelQuery);
    mysqli_close($conn);
}catch (Exception $e){
  $error = $e->getMessage();
  echo $error;
}
}
?>