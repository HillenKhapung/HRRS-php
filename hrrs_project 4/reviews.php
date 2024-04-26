<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student Reviews</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .review {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #e0e0e0;
            background-color: #ffffff;
        }

        .review h4 {
            color: #333;
            font-size: 20px;
            margin: 0;
        }

        .review p {
            color: #666;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Student Reviews</h1>
        <?php 
            // Connect to the database 
            $db = new mysqli("localhost", "root", "", "hostel_reservation_system"); 
            
            // Get the reviews from the database 
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            $query = "SELECT * FROM student_reviews ORDER BY review_id DESC"; 
            $result = $db->query($query); 
            
            // Display the reviews 
            while ($row = $result->fetch_assoc()) { 
                echo "<div class='review'>";
                echo "<h4>" . htmlspecialchars($row["student_name"]) . "</h4>";
                echo "<p>" . nl2br(htmlspecialchars($row["review_text"])) . "</p>";
                echo "</div>"; 
            } 
        ?>
    </div>
</body>
</html>