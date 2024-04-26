<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Page</title>
</head>
<body>
    <h1>Hi, this is the student page!</h1>

    <?php
        $email = isset($_GET['email']) ? $_GET['email'] : '';
        $editProfileURL = "edit_profile.php?email=" . urlencode($email);
    ?>

    <a href="<?php echo $editProfileURL; ?>" class="edit_profile">Edit Profile</a>
</body>
</html>
