<div class="wrapper">
    <div class="sidebar">
        <?php include('dashboard.php'); ?>
    </div>
    <div class="content">
        <h2>Owners</h2>
        <div class="table-container">
            <table border="1" cellpadding="7px" cellspacing="7px" style="border-collapse: collapse">
                <thead>
                    <tr>
                        <th>Owner ID</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact Number</th>
                        <th>PAN Number</th>
                        <th>Citizenship Number</th>
                        <th>Owners Photo</th>
                        <th>Owners Citizenship Photo</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('db_connection.php');

                    $sql = "SELECT * FROM Owners";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr id="owner-row-' . $row['owner_id'] . '">';
                            echo '<td>' . $row['owner_id'] . '</td>';
                            echo '<td>' . $row['email'] . '</td>';
                            echo '<td>' . $row['password'] . '</td>';
                            echo '<td>' . $row['owner_name'] . '</td>';
                            echo '<td>' . $row['owner_address'] . '</td>';
                            echo '<td>' . $row['owner_contact_number'] . '</td>';
                            echo '<td>' . $row['owner_pan_number'] . '</td>';
                            echo '<td>' . $row['owner_citizenship_number'] . '</td>';
                            echo '<td><img src="' . $row['owner_photo_upload'] . '" alt="Owner Photo" width="100" height="100"></td>'; // Display owner photo
                            echo '<td><img src="' . $row['owner_citizenship_photo'] . '" alt="Owner Citizenship" width="100" height="100"></td>'; // Display owner citizenship photo
                            echo '<td><a href="delete.php?table=Owners&id=' . $row['owner_id'] . '">Delete</a></td>';
                            echo '<td><a href="update_owner.php?id=' . $row['owner_id'] . '">Edit</a></td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="11">No owners found in the table.</td></tr>';
                    }

                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
