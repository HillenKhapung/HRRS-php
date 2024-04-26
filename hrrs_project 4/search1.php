<?php
session_start();
include('db_connection.php');

// Check if the user is logged in
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Fetch the student_id for the current user
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

    $_SESSION["student_id"] = $row['student_id'];

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include('student_header.php');
    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Search Page</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <form action="" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" name="search" required value="<?php if(isset($_GET['search'])){echo htmlspecialchars($_GET['search']); } ?>" class="form-control" placeholder="Search the location or hostel name">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Hostel Name</th>
                                    <th>Available rooms</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                
                                if(isset($_GET['search'])) {
                                    $filtervalues = '%' . $_GET['search'] . '%';
                                    $query = "SELECT * FROM `hostels` WHERE hostel_name LIKE ? OR hostel_location LIKE ?";
                                    $stmt = mysqli_prepare($conn, $query);
                                    mysqli_stmt_bind_param($stmt, "ss", $filtervalues, $filtervalues);

                                    if(mysqli_stmt_execute($stmt)) {
                                        $result = mysqli_stmt_get_result($stmt);

                                        if(mysqli_num_rows($result) > 0) {
                                            while($items = mysqli_fetch_assoc($result)) {
                                                $_SESSION['hostel_id'] = $items["hostel_id"];
                                ?>
                                                <tr>
                                                    <td><a href="<?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === TRUE) { echo 'booking.html?hostel_id=' . $items['hostel_id']; } else { echo 'login.html'; } ?>"><?php echo htmlspecialchars($items['hostel_name']); ?></a></td>
                                                    <td><?= $items['hostel_no_of_beds']; ?></td>  
                                                </tr>
                                <?php
                                            }
                                        } else {
                                ?>
                                            <tr>
                                                <td colspan="2">No Hostels Found</td>
                                            </tr>
                                <?php
                                        }
                                    } else {
                                        die("Query execution failed: " . mysqli_error($conn));
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
