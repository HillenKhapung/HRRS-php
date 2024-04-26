
<h2>Reviews</h2>
<table id="reviews-table" border="1" cellpadding="7px" cellspacing="7px" style="border-collapse: collapse">
  <thead>
    <tr>
    
      <th>Student ID</th>
  
      <th>Review Text</th>
    </tr>
  </thead>
  <tbody>
    <?php
    
    include('db_connection.php');
    
    if (isset($hostelId)) {
      $sql = "SELECT * FROM Student_Reviews WHERE hostel_id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $hostelId);
      $stmt->execute();
      $result = $stmt->get_result();
    
      if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<tr id="review-row-' . $row['review_id'] . '">';
         
          echo '<td>' . $row['student_id'] . '</td>';
         
          echo '<td>' . $row['review_text'] . '</td>';
          echo '</tr>';
        }
      } else {
        echo '<tr><td colspan="4">No student reviews found in the table.</td></tr>';
      }
    
      $stmt->close();
    } else {
      echo '<tr><td colspan="4">No hostel ID available.</td></tr>';
    }
    
    mysqli_close($conn);
    ?>
  
  </tbody>
</table>