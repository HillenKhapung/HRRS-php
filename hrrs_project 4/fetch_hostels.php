<div class="wrapper">
    <div class="sidebar">
        <?php include('dashboard.php'); ?>
    </div>
    <div class="content">
        <h2>Hostels</h2>
        <div class="table-container">
            <table border="1" cellpadding="7px" cellspacing="7px" style="border-collapse: collapse">
                <thead>
                    <tr>
                        <th>Hostel ID</th>
                        <th>Owner ID</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Contact Number</th>
                        <th>No. of Beds</th>
                        <th>Price per Bed</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('db_connection.php');

                    $sql = "SELECT * FROM Hostels";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr id="hostel-row-' . $row['hostel_id'] . '">';
                            echo '<td>' . $row['hostel_id'] . '</td>';
                            echo '<td>' . $row['hostel_owner_id'] . '</td>';
                            echo '<td>' . $row['hostel_name'] . '</td>';
                            echo '<td>' . $row['hostel_location'] . '</td>';
                            echo '<td>' . $row['hostel_contact_number'] . '</td>';
                            echo '<td>' . $row['hostel_no_of_beds'] . '</td>';
                            echo '<td>' . $row['Price_per_bed'] . '</td>';
                            echo '<td>' . $row['hostel_description'] . '</td>';
                            echo '<td><a href="update_hostel.php?id=' . $row['hostel_id'] . '">Edit</a></td>'; // Add this line for the Edit button
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="10">No hostels found in the table.</td></tr>';
                    }

                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
