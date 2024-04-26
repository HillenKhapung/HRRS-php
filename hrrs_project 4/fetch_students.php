<div class="wrapper">
    <div class="sidebar">
        <?php include('dashboard.php'); ?>
    </div>
    <div class="content">
        <h2>Students</h2>
        <div class="table-container">
            <table border="1" cellpadding="7px" cellspacing="7px" style="border-collapse: collapse">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact Number</th>
                        <th>College ID</th>
                        <th>Student Photo</th>
                        <th>Student Card Photo</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('db_connection.php');

                    $sql = "SELECT * FROM Students";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr id="student-row-' . $row['student_id'] . '">';
                            echo '<td>' . $row['student_id'] . '</td>';
                            echo '<td>' . $row['email'] . '</td>';
                            echo '<td>' . $row['password'] . '</td>';
                            echo '<td>' . $row['student_name'] . '</td>';
                            echo '<td>' . $row['student_address'] . '</td>';
                            echo '<td>' . $row['student_contact_number'] . '</td>';
                            echo '<td>' . $row['student_college_id'] . '</td>';
                            echo '<td><img src="' . $row['student_photo_upload'] . '" alt="Student Photo" width="100" height="100"></td>';
                            echo '<td><img src="' . $row['student_card_upload'] . '" alt="Student Card" width="100" height="100"></td>';
                            echo '<td><a href="delete.php?table=Students&id=' . $row['student_id'] . '">Delete</a></td>';
                            echo '<td><a href="update_student.php?id=' . $row['student_id'] . '">Edit</a></td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="10">No students found in the table.</td></tr>';
                    }

                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
