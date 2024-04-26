<!DOCTYPE html>
<html>

<head>
  <title>Edit Profile</title>

  <style>
    .preview-image {
      max-width: 200px;
      max-height: 200px;
      margin-top: 10px;
    }
  </style>

  <link rel="stylesheet" href="edit_profile.css">
  <script>
    function showPreview(input, previewId) {
      var preview = document.getElementById(previewId);
      var files = input.files;

      if (files && files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
          preview.src = e.target.result;
        };

        reader.readAsDataURL(files[0]);
        preview.style.display = "block";
      }
    }
  </script>
</head>

<body>
<?php
include('owner_header.php');
?>
  <?php
  // Establish database connection
  include('db_connection.php');
  session_start();

  // Check if the email is stored in the session
  if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Function to retrieve the user type based on the email
    function getUserType($email) {
      global $conn;

      // Check if the email address is valid
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return null;
      }

      // Check if the user exists in the database
      $query = "SELECT * FROM Users WHERE email = ?";
      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      if ($result && mysqli_num_rows($result) == 0) {
        return null;
      }

      // Get the user type from the database
      $row = mysqli_fetch_assoc($result);
      return $row['user_type'];
    }

    // Function to retrieve the profile data from the appropriate table
    function getProfileData($conn, $table, $idColumn, $email) {
      $query = "SELECT * FROM $table WHERE email = ?";
      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row;
      }

      return null;
    }

    // Check if the form is submitted for profile updates
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Update address
      if (isset($_POST['updateAddressBtn'])) {
        $newAddress = $_POST['address'];
        $sql = "UPDATE $table SET $addressColumn = ? WHERE email = ?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $newAddress, $email);

        if (mysqli_stmt_execute($stmt)) {
          echo "Address updated successfully.";
        } else {
          echo "Error updating address: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
      }

      // Update contact number
      if (isset($_POST['updateContactBtn'])) {
        $newContactNumber = $_POST['contact'];
        $sql = "UPDATE $table SET $contactColumn = ? WHERE email = ?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $newContactNumber, $email);

        if (mysqli_stmt_execute($stmt)) {
          echo "Contact number updated successfully.";
        } else {
          echo "Error updating contact number: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
      }

      // Update password
      if (isset($_POST['updatePasswordBtn'])) {
        $newPassword = md5($_POST['password']);
        $sql = "UPDATE Users SET password = ? WHERE email = ?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $newPassword, $email);

        if (mysqli_stmt_execute($stmt)) {
          echo "Password updated successfully.";
        } else {
          echo "Error updating password: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
      }
    }

    // Retrieve the user's profile information from the appropriate table based on user type
    $userType = getUserType($email);

    if ($userType == 'student') {
      $table = 'Students';
      $idColumn = 'student_id';
      $nameColumn = 'student_name';
      $addressColumn = 'student_address';
      $contactColumn = 'student_contact_number';
      $photoColumn = 'student_photo_upload';
    } elseif ($userType == 'owner') {
      $table = 'Owners';
      $idColumn = 'owner_id';
      $nameColumn = 'owner_name';
      $addressColumn = 'owner_address';
      $contactColumn = 'owner_contact_number';
      $photoColumn = 'owner_photo_upload';
    } else {
      echo "Invalid user type.";
      exit();
    }

    $profileData = getProfileData($conn, $table, $idColumn, $email);

    mysqli_close($conn);
  } else {
    echo "Session email not found. Please log in.";
    exit();
  }
  ?>

  <h1>Profile</h1>
  <form method="POST">
    <div>
      <h2>Personal Information</h2>
      <label for="name">Name:</label>
      <span id="name"><?php echo $profileData[$nameColumn]; ?></span><br><br>
      <label for="email">Email:</label>
      <span id="email"><?php echo $email; ?></span><br><br>

      <label for="address">Address:</label>
      <span id="addressInput"><?php echo $profileData[$addressColumn]; ?></span><br><br>

      <label for="contact">Contact Number:</label>
      <span id="contactInput"><?php echo $profileData[$contactColumn]; ?></span><br><br>

      <?php
      if ($profileData[$photoColumn] !== null) {
        echo '<img src="' . $profileData[$photoColumn] . '" class="preview-image" alt="Profile Photo"><br><br>';
      }
      ?>
    </div>

    <h2>Edit Profile</h2>
    <label for="address">Address:</label>
    <input type="text" id="addressInput" name="address" value="<?php echo $profileData[$addressColumn]; ?>">
    <button type="submit" name="updateAddressBtn">Update</button><br><br>

    <label for="contact">Contact Number:</label>
    <input type="text" id="contactInput" name="contact" value="<?php echo $profileData[$contactColumn]; ?>">
    <button type="submit" name="updateContactBtn">Update</button><br><br>

    <label for="password">Password:</label>
    <input type="password" id="passwordInput" name="password">
    <button type="submit" name="updatePasswordBtn">Update</button><br><br>
  </form>
</body>

</html>
