<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Reservations</title>
</head>
<body>
  <h2>Reservations</h2>
  <table id="reservations-table" border="1" cellpadding="7px" cellspacing="7px" style="border-collapse: collapse">
    <thead>
      <tr>
        <th>Student ID</th>
        <th>No. of Beds</th>
        <th>Arrival Date</th>
        <th>Departure Date</th>
      </tr>
    </thead>
    <tbody>
      <?php
      include('db_connection.php');
      
      // Define $hostelId or fetch it from somewhere
      $hostelId = 1; // Replace with your actual value
      
      if (isset($hostelId)) {
        $sql = "SELECT * FROM Reservations WHERE hostel_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $hostelId);
        $stmt->execute();
        $result = $stmt->get_result();
      
        if ($result->num_rows > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr id="reservation-row-' . $row['reservation_id'] . '">';
            echo '<td>' . $row['student_id'] . '</td>';
            echo '<td>' . $row['no_of_beds'] . '</td>';
            echo '<td>' . $row['arrival_date'] . '</td>';
            echo '<td>' . $row['departure_date'] . '</td>';
            echo '</tr>';
          }
        } else {
          echo '<tr><td colspan="4">No reservations found in the table.</td></tr>';
        }
      
        $stmt->close();
      } else {
        echo '<tr><td colspan="4">No hostel ID available.</td></tr>';
      }
      
      mysqli_close($conn);
      ?>
    </tbody>
  </table>
</body>
</html>
