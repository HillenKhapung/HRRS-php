<div class="wrapper">
    <div class="sidebar">
        <?php include('dashboard.php'); ?>
    </div>
    <div class="content">
        <h2>Colleges</h2>
        <div class="table-container">
            <table border="1" cellpadding="7px" cellspacing="7px" style="border-collapse: collapse">
                <thead>
                    <tr>
                        <th>College ID</th>
                        <th>Name</th>
                        <th>Domain</th>
                        <th>Location</th>
                        <th>Contact Number</th>
                        <th>Action</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('db_connection.php');

                    $sql = "SELECT * FROM Colleges";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr id="college-row-' . $row['college_id'] . '">';
                            echo '<td>' . $row['college_id'] . '</td>';
                            echo '<td>' . $row['college_name'] . '</td>';
                            echo '<td>' . $row['college_domain'] . '</td>';
                            echo '<td>' . $row['college_location'] . '</td>';
                            echo '<td>' . $row['college_contact_number'] . '</td>';
                            echo '<td><a href="delete.php?table=Colleges&id=' . $row['college_id'] . '">Delete</a></td>';
                            echo '<td><a href="update_college.php?id=' . $row['college_id'] . '">Edit</a></td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="6">No colleges found in the table.</td></tr>';
                    }

                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
        <hr>

        <h2>Add College</h2>
        <form action="add_college.php" method="POST">
            <label for="collegeName">College Name:</label>
            <input type="text" id="collegeName" name="collegeName" required><br><br>

            <label for="collegeDomain">College Domain:</label>
            <input type="text" id="collegeDomain" name="collegeDomain" required><br><br>

            <label for="collegeLocation">College Location:</label>
            <input type="text" id="collegeLocation" name="collegeLocation" required><br><br>

            <label for="collegeContactNumber">Contact Number:</label>
            <input type="text" id="collegeContactNumber" name="collegeContactNumber" required><br><br>

            <input type="submit" value="Submit">
        </form>
    </div>
</div>
