<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Search Page</title>
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
        <li><a href="homepage.html">Home</a></li>
        <li><a href="reservation.php">Reservations</a></li>
        <li><a href="reviews.php">Reviews</a></li>
        <li><a href="search1.php">search</a></li>
        <li style="margin-left: auto;"><a href="edit_profile.php?email=<?php echo urlencode($email); ?>">Edit Profile</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>
</body>
</html>