<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "cts_db";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "❌ Connection failed: " . $conn->connect_error]));
}

// ✅ Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $description = isset($_POST['description']) ? mysqli_real_escape_string($conn, $_POST['description']) : '';
    $unit = isset($_POST['unit']) ? mysqli_real_escape_string($conn, $_POST['unit']) : '';

    if (!empty($description) && !empty($unit)) {
        $status = "Pending";
        $date = date('Y-m-d H:i:s');

        // Insert into the database
        $query = "INSERT INTO concerns (description, unit, status, created_at) 
                  VALUES ('$description', '$unit', '$status', '$date')";

        if (mysqli_query($conn, $query)) {
            echo json_encode(["success" => true, "message" => "✅ Concern submitted successfully!"]);
        } else {
            echo json_encode(["success" => false, "message" => "❌ Error: " . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "❌ Missing form data!"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "❌ Form not submitted!"]);
}

$conn->close();
?>
