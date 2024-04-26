<?php
include('db_connection.php');

function moveUploadedFile($file, $directory)
{
    if ($file && !empty($file['name'])) {
        $path = $directory . $file['name'];
        if (!move_uploaded_file($file['tmp_name'], $path)) {
            echo "Error moving file: " . $file['name'];
            exit();
        }
        return $path;
    }
    return null;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];

    $photoUploadPath = moveUploadedFile($_FILES['photo_upload'], 'uploads/');

    $userType = $_POST['user_type'];
    $hashedPassword = md5($password);

    if ($userType === 'student') {
        $collegeId = $_POST['roll_number'];
        $studentCardUploadPath = moveUploadedFile($_FILES['card'], 'uploads/');

        $emailDomain = explode('@', $email)[1];
        $collegeDomains = [];

        $sql = "SELECT college_domain FROM Colleges";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $collegeDomains[] = $row['college_domain'];
            }
        }

        if (!in_array($emailDomain, $collegeDomains)) {
            echo "Invalid email domain. Please use a valid student email address.";
            exit();
        }

        $sql = "INSERT INTO Users (email, user_type, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $email, $userType, $hashedPassword);

        if (!$stmt->execute()) {
            echo "Error inserting user data: " . $stmt->error;
            exit();
        }

        $userId = $stmt->insert_id;

        $sql = "INSERT INTO Students (email, student_name, student_address, student_contact_number, password, student_college_id, student_card_upload, student_photo_upload) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $email, $name, $address, $contact, $hashedPassword, $collegeId, $studentCardUploadPath, $photoUploadPath);

        if (!$stmt->execute()) {
            echo "Error inserting student data: " . $stmt->error;
            exit();
        }

        header("Location: login.html");
    }

    if ($userType === 'owner') {
        $hostelName = $_POST['hostel_name'];
        $hostelLocation = $_POST['hostel_location'];
        $contactNumber = $_POST['contact_number'];
        $hostelDescription = $_POST['hostel_description'];
        $panNumber = $_POST['pan_number'];
        $citizenshipNumber = $_POST['citizenship_number'];

        $citizenshipUploadPath = moveUploadedFile($_FILES['citizenship_upload'], 'uploads/');

        $collegeLocations = [];
        $sql = "SELECT college_location FROM Colleges";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $collegeLocations[] = $row['college_location'];
            }
        }

        if (!in_array($hostelLocation, $collegeLocations)) {
            echo "Invalid hostel location. Please use a valid hostel location.";
            exit();
        }

        $sql = "INSERT INTO Users (email, user_type, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $email, $userType, $hashedPassword);

        if (!$stmt->execute()) {
            echo "Error inserting user data: " . $stmt->error;
            exit();
        }

        $userId = $stmt->insert_id;

        $sql = "INSERT INTO Owners (email, owner_name, owner_address, owner_contact_number, password, owner_pan_number, owner_citizenship_number, owner_citizenship_photo, owner_photo_upload) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssss", $email, $name, $address, $contact, $hashedPassword, $panNumber, $citizenshipNumber, $citizenshipUploadPath, $photoUploadPath);

        if (!$stmt->execute()) {
            echo "Error inserting owner data: " . $stmt->error;
            exit();
        }

        $ownerId = $stmt->insert_id;

        $sql = "INSERT INTO Hostels (hostel_owner_id, hostel_name, hostel_location, hostel_contact_number, hostel_description) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $ownerId, $hostelName, $hostelLocation, $contactNumber, $hostelDescription);

        if (!$stmt->execute()) {
            echo "Error inserting hostel data: " . $stmt->error;
            exit();
        }

        header("Location: login.html");
    }

    $stmt->close();
    $conn->close();
}
?>
