<?php
session_start();

 $student_id = $_SESSION["student_id"];
$email=$_SESSION["email"];
 $hostel_id = $_SESSION["hostel_id"];
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
        $hostel_id = $row["hostel_id"];
    }
 }
    
    // $sql5 = "SELECT *  from `reservations` where `student_id` = $student_id";
    // $query_run = mysqli_query($conn, $sql5);
    // while (isset($query_run["id"])) {
    //     $hostel_id = $query_run["hostel_id"];
    // }
    $sql1="SELECT * from hostels where hostel_id=$hostel_id";
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
}
if(isset($_GET['review'])){
    header('Location:http://localhost/HRRS/review.html');
exit();
}

?>

<html>
<?php
    include('student_header.php');
    ?>
    <body>
        <form method="get" action="booked1.php">
            <table border="1" style="border-collapse: collapse;">
                <tr>
                    <td>student Id</td>
                    <td><input type="text" name="student_id" value="<?php echo $student_id; ?>"></td>
                </tr>
                <tr>
                    <td>email</td>
                    <td><input type="text" name="email" value="<?php echo $email; ?>"></td>
                </tr>
                <tr>
                    <td colspan="2">YOU HAVE SUCCESSFULLY BOOKED A ROOM</td>
                </tr>
            </table>
            <input type="submit" name="cancel" value="cancel booking">
            <input type="submit" name="review" value="give review">
        </form>
    </body>
</html>

