<?php
// Include the database connection (config.php)
include 'config.php';

// Start a session and verify the CSRF token
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        // Valid CSRF token

        // Get data from the form
        $id = $_GET['id']; // Get the ID from the URL
        $first_name = htmlspecialchars($_POST['first_name'], ENT_QUOTES, 'UTF-8');
        $last_name = htmlspecialchars($_POST['last_name'], ENT_QUOTES, 'UTF-8');
        $phone_number = htmlspecialchars($_POST['phone_number'], ENT_QUOTES, 'UTF-8');
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $dob = htmlspecialchars($_POST['dob'], ENT_QUOTES, 'UTF-8');
        $gender_id = intval($_POST['gender']);
        $skills_ids = $_POST['skills'];
        $json_skills = json_encode($skills_ids);
        $state_id = intval($_POST['state']);
        $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');

        // Handle image upload (if a new image is provided)
        $profile_image_path = ''; // Initialize with an empty string
        if ($_FILES['profile_image']['name']) {
            $target_directory = 'uploads/';
            $target_file = $target_directory . basename($_FILES['profile_image']['name']);
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
                $profile_image_path = $target_file;
            } else {
                echo "Error uploading image.";
                exit;
            }
        }
        // Use prepared statements to prevent SQL injection
        if (!empty($profile_image_path)) {
            $stmt = $conn->prepare("UPDATE `people` SET 
       first_name = ?, 
       last_name = ?, 
       phone_number = ?, 
       email = ?, 
       dob = ?, 
       gender_id = ?, 
       skills_id = ?, 
       state_id = ?, 
       description = ?, 
       profile_image = ?
       WHERE id = ?");

            $stmt->bind_param("ssssssssssi", $first_name, $last_name, $phone_number, $email, $dob, $gender_id, $json_skills, $state_id, $description, $profile_image_path, $id);
        } else {
            $stmt = $conn->prepare("UPDATE `people` SET 
       first_name = ?, 
       last_name = ?, 
       phone_number = ?, 
       email = ?, 
       dob = ?, 
       gender_id = ?, 
       skills_id = ?, 
       state_id = ?, 
       description = ?
       WHERE id = ?");

            $stmt->bind_param("sssssssssi", $first_name, $last_name, $phone_number, $email, $dob, $gender_id, $json_skills, $state_id, $description, $id);
        }


        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("Location: index.php?msg=Record Updated Successfully");
            exit;
            // You can redirect the user to a success page or perform any other actions here.
        } else {
            header("Location: edit.php?id=$id&msg=No changes were made.");

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