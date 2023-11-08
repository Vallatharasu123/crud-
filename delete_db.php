<?php
// Include the database connection (config.php)
include 'config.php';

// Start a session and verify the CSRF token
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_GET['csrf_token'])) {
        // Valid CSRF token
echo "Token success";
        // Get the ID of the record to be deleted
        $id = $_GET['id']; // Get the ID from the URL

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("DELETE FROM `people` WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("Location: index.php?msg=Record Deleted Successfully");
            exit;
            // You can redirect the user to a success page or perform any other actions here.
        } else {
            echo "Error deleting the record.";
        }
    } else {
        // Invalid CSRF token; handle the error
        echo "Invalid CSRF token. This request may be a CSRF attack.";
    }
} else {
    // Invalid request method; handle the error
    echo "Invalid request method.";
}

// Close the database connection
$conn->close();
?>
