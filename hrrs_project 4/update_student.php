<?php
include('db_connection.php');

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];
    $sql = "SELECT * FROM Students WHERE student_id = $student_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        // You can use $row values to pre-fill the form fields for editing
        $email = $row['email'];
        $password = $row['password'];
        $student_name = $row['student_name'];
        $student_address = $row['student_address'];
        $student_contact_number = $row['student_contact_number'];
        $student_college_id = $row['student_college_id'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission for updating student information
    $new_email = $_POST['email'];
    $new_password = md5($_POST['password']); // Hash the password using MD5
    $new_student_name = $_POST['studentName'];
    $new_student_address = $_POST['studentAddress'];
    $new_student_contact_number = $_POST['studentContactNumber'];
    $new_student_college_id = $_POST['studentCollegeId'];

    $update_sql = "UPDATE Students 
                   SET email = '$new_email', 
                       password = '$new_password', 
                       student_name = '$new_student_name', 
                       student_address = '$new_student_address', 
                       student_contact_number = '$new_student_contact_number', 
                       student_college_id = '$new_student_college_id'
                   WHERE student_id = $student_id";

    if (mysqli_query($conn, $update_sql)) {
        // Student information updated successfully
        header("Location: fetch_students.php"); // Redirect to dashboard or any other page
        exit();
    } else {
        echo "Error updating student information: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
</head>
<body>
    <h2>Edit Student</h2>
    <form action="" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" value="<?php echo $password; ?>" required><br><br>

        <label for="studentName">Name:</label>
        <input type="text" id="studentName" name="studentName" value="<?php echo $student_name; ?>" required><br><br>

        <label for="studentAddress">Address:</label>
        <input type="text" id="studentAddress" name="studentAddress" value="<?php echo $student_address; ?>" required><br><br>

        <label for="studentContactNumber">Contact Number:</label>
        <input type="text" id="studentContactNumber" name="studentContactNumber" value="<?php echo $student_contact_number; ?>" required><br><br>

        <label for="studentCollegeId">College ID:</label>
        <input type="text" id="studentCollegeId" name="studentCollegeId" value="<?php echo $student_college_id; ?>" required><br><br>

        <input type="submit" value="Update">
    </form>
</body>
</html>
