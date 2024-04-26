<?php
// Establish database connection
include('db_connection.php');
session_start();
// Retrieve the email from the query parameter
$email = $_SESSION['email'];

// Check if the email address is valid
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo "Invalid email address";
  exit();
}

// Check if any form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Update Hostel Description
  if (isset($_POST['updateDescriptionBtn'])) {
    $newDescription = $_POST['descriptionInput'];
    $sql = "UPDATE Hostels SET hostel_description = ? WHERE hostel_owner_id = (SELECT owner_id FROM Owners WHERE email = ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $newDescription, $email);

    if ($stmt->execute()) {
      echo "Hostel Description updated successfully.";
    } else {
      echo "Error updating Hostel Description: " . $stmt->error;
    }
  }

  // Update No. of Beds
  if (isset($_POST['updateBtn'])) {
    $newNoOfBeds = $_POST['bedsInput'];
    $sql = "UPDATE Hostels SET hostel_no_of_beds = ? WHERE hostel_owner_id = (SELECT owner_id FROM Owners WHERE email = ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $newNoOfBeds, $email);

    if ($stmt->execute()) {
      echo "No. of Beds updated successfully.";
    } else {
      echo "Error updating No. of Beds: " . $stmt->error;
    }
  }

  // Set Price
  if (isset($_POST['setPriceBtn'])) {
    $newPrice = $_POST['priceInput'];
    $sql = "UPDATE Hostels SET Price_per_bed = ? WHERE hostel_owner_id = (SELECT owner_id FROM Owners WHERE email = ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $newPrice, $email);

    if ($stmt->execute()) {
      echo "Price set successfully.";
    } else {
      echo "Error setting Price: " . $stmt->error;
    }
  }
}

// Retrieve owner and hostel information based on the email
$sql = "SELECT Owners.owner_name, Hostels.hostel_name, Hostels.hostel_location, Hostels.hostel_contact_number, Hostels.hostel_description, Hostels.hostel_no_of_beds, Hostels.Price_per_bed, Hostels.hostel_id
        FROM Owners
        INNER JOIN Hostels ON Owners.owner_id = Hostels.hostel_owner_id
        WHERE Owners.email = ? LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();

  $ownerName = $row['owner_name'];
  $hostelName = $row['hostel_name'];
  $address = $row['hostel_location'];
  $contactNumber = $row['hostel_contact_number'];
  $hostelDescription = $row['hostel_description'];
  $noOfBeds = $row['hostel_no_of_beds'];
  $price = $row['Price_per_bed'];
  $hostelId = $row['hostel_id'];

  $stmt->close();
} else {
  echo "No hostel found for the given email.";
  exit();
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Hostel Reservation System</title>
  <link rel="stylesheet" href="owner.css">
  <style>
    /* Style for the header */
/* Style for the header */
header {
  background-color: #3498db;
  color: #fff;
  padding: 10px 0;
}

/* Style for the navigation menu */
nav ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  display: flex;
}

nav ul li {
  margin-right: 20px;
}

nav ul li:last-child {
  margin-right: 0;
}

nav ul li a {
  text-decoration: none;
  color: #fff;
  font-weight: bold;
  font-size: 16px;
  transition: color 0.3s;
}

nav ul li a:hover {
  color: #e74c3c;
}

/* Style for the rightmost links (Edit Profile and Logout) */
nav ul li:last-child a {
  margin-left: auto; /* Push them to the right */
}


  </style>
</head>

<body>
  <header>
    <nav>
      <ul>
        <li><a href="owner.php">Hostel Information</a></li>
        <li><a href="fetch_reservations_owner.php">Reservations</a></li>
        <li><a href="fetch_reviews_owner.php">Reviews</a></li>
        <li style="margin-left: auto;"><a href="edit_profile.php?email=<?php echo urlencode($email); ?>">Edit Profile</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <div class="container">
    <h1>Welcome, <?php echo $ownerName; ?>!</h1>

    <div id="hostel-info-section">
      <h2>Hostel Information:</h2>
      <label for="hostelName">Hostel Name:</label>
      <span class="info-value"><?php echo $hostelName; ?></span>
      <br><br>
      <label for="address">Address:</label>
      <span class="info-value"><?php echo $address; ?></span>
      <br><br>
      <label for="contactNumber">Contact Number:</label>
      <span class="info-value"><?php echo $contactNumber; ?></span>
      <br><br>
      <label for="hostelDescription">Hostel Description:</label>
      <span class="info-value"><?php echo $hostelDescription; ?></span>
      <br><br>
      <label for="noOfBeds">No. of Beds:</label>
      <span class="info-value"><?php echo $noOfBeds; ?></span>
      <br><br>
      <label for="price">Price:</label>
      <span class="info-value">Rs <?php echo $price; ?></span>
    </div>

    <hr>
    <div id="update-description-section">
      <form method="post" action="owner.php?email=<?php echo $email; ?>">
        <label for="descriptionInput">New Hostel Description:</label>
        <input type="text" id="descriptionInput" name="descriptionInput">
        <button type="submit" id="updateDescriptionBtn" name="updateDescriptionBtn">Update Description</button>
      </form>
    </div>

    <div id="update-beds-section">
      <form method="post" action="owner.php?email=<?php echo $email; ?>">
        <label for="bedsInput">New No. of Beds:</label>
        <input type="number" id="bedsInput" name="bedsInput">
        <button type="submit" id="updateBtn" name="updateBtn">Update</button>
      </form>
    </div>

    <div id="set-price-section">
      <form method="post" action="owner.php?email=<?php echo $email; ?>">
        <label for="priceInput">New Price:</label>
        <input type="number" id="priceInput" name="priceInput">
        <button type="submit" id="setPriceBtn" name="setPriceBtn">Set Price</button>
      </form>
      
</body>

</html>
