<div class="wrapper" >
<div class="sidebar">
        <?php include('dashboard.php'); ?>
    </div>
    <div class="content">
            <h2>Colleges</h2>
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
              <th>Action</th> 
            </tr>
          </thead>
          <tbody>
          <?php
include('db_connection.php');

$sql = "SELECT * FROM Reservations";
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
    echo '<td rowspan=0.5><a href="delete.php?table=Reservations&id=' . $row['owner_id'] . '">Delete</a></td>';
    echo '<td rowspan=0.5><a href="update_reservation.php?id=' . $row['reservation_id'] . '">Edit</a></td>';
    echo '</tr>';
  }
} else {
  echo '<tr><td colspan="6">No reservations found in the table.</td></tr>';
}

mysqli_close($conn);
?>

          </tbody>
        </table>
      </div>
</div>
</div>
