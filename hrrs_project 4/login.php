<?php
include('db_connection.php');

function sanitizeInput($input) {
    // Perform any necessary input sanitization here
    return $input;
}

// Start a PHP session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitizeInput($_POST["email"]);
    $password = sanitizeInput($_POST["password"]);

    // Hash the provided password using MD5
    $hashedPassword = md5($password);

    $query = "SELECT user_type FROM Users WHERE email = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $email, $hashedPassword); // Use hashed password here
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $userType = $row['user_type'];

        // Store the email in the session
        $_SESSION['email'] = $email;

        mysqli_free_result($result);
        mysqli_close($conn);

        // Redirect based on user type
        if ($userType == 'student') {
            $_SESSION['loggedin'] = TRUE;
            header("Location: reservation.php");
            exit();
        } elseif ($userType == 'owner') {
            $_SESSION['loggedin'] = TRUE;
            header("Location: owner.php");
            exit();
        } elseif ($userType == 'admin') {
            $_SESSION['loggedin'] = TRUE;
            header("Location: admin.php");
            exit();
        }
    } else {
        echo "Invalid email or password. Please try again.";
    }
}

mysqli_close($conn);
?>
