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
              <th>Review ID</th>
              <th>Student ID</th>
              <th>Hostel ID</th>
              <th>Review Text</th>
              <th>Action</th> 
            </tr>
          </thead>
          <tbody>
          <?php
include('db_connection.php');

$sql = "SELECT * FROM Student_Reviews";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr id="review-row-' . $row['review_id'] . '">';
    echo '<td>' . $row['review_id'] . '</td>';
    echo '<td>' . $row['student_id'] . '</td>';
    echo '<td>' . $row['hostel_id'] . '</td>';
    echo '<td>' . $row['review_text'] . '</td>';
    echo '<td><a href="delete.php?table=Student_Reviews&id=' . $row['review_id'] . '">Delete</a></td>';
    echo '</tr>';
  }
} else {
  echo '<tr><td colspan="4">No student reviews found in the table.</td></tr>';
}

mysqli_close($conn);
?>
          </tbody>
        </table>
      </div>
</div>
</div>