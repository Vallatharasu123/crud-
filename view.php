<?php
include 'header.php';

// Include the database connection (config.php)
include 'config.php';

// Check if a data ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the person's data from the database
    $sql = "SELECT * FROM `people` WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Extract data from the fetched row
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $phone_number = $row['phone_number'];
        $email = $row['email'];
        $dob = $row['dob'];
        $gender_id = $row['gender_id'];
        $skills_ids = json_decode($row['skills_id']);
        $state_id = $row['state_id'];
        $description = $row['description'];
        $profile_image_path = $row['profile_image'];
    } else {
        echo "Person not found with ID: $id";
        exit;
    }
} else {
    echo "Data ID is missing in the URL.";
    exit;
}
?>

<div class="container">
    
  <h5 class="text-center">View Person</h5>
  <a href='edit.php?id=<?php echo "$id"; ?>' role='button' class='btn btn-primary float-end'>
          <i class='bx bx-pencil'></i>  Edit
        </a>
  <div class="row justify-content-center">
    <div class="col-md-10 mt-2">
      <div class="row">
      <div class="col-md-4">
  <div class="avatar-preview">
    <img src="<?php echo $profile_image_path; ?>" alt="Profile Image" class="img-fluid">
  </div>
</div>

        <div class="col-md-8">
          <div class="mb-3">
            <label for="first_name">First Name: </label>
            <p><?php echo $first_name; ?></p>
          </div>
          <div class="mb-3">
            <label for="last_name">Last Name: </label>
            <p><?php echo $last_name; ?></p>
          </div>
          <div class="mb-3">
            <label for="phone_number">Phone Number: </label>
            <p><?php echo $phone_number; ?></p>
          </div>
          <div class="mb-3">
            <label for="email">Email: </label>
            <p><?php echo $email; ?></p>
          </div>
          <div class="mb-3">
            <label for="dob">Date of Birth: </label>
            <p><?php echo $dob; ?></p>
          </div>
          <div class="mb-3">
            <label for="gender">Gender: </label>
            <p>
              <?php
              // SQL query to fetch gender data
              $sql = "SELECT gender FROM `gender` WHERE id = $gender_id";
              $result = $conn->query($sql);
              if ($result->num_rows > 0) {
                  $gender = $result->fetch_assoc();
                  echo $gender['gender'];
              }
              ?>
            </p>
          </div>
          <div class="mb-3">
            <label for="skills">Skills: </label>
            <p>
              <?php
              // SQL query to fetch skills data
              $skills = [];
              foreach ($skills_ids as $skill_id) {
                  $sql = "SELECT skill_name FROM `skills` WHERE id = $skill_id";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                      $skill = $result->fetch_assoc();
                      $skills[] = $skill['skill_name'];
                  }
              }
              echo implode(', ', $skills);
              ?>
            </p>
          </div>
          <div class="mb-3">
            <label for="state">State: </label>
            <p>
              <?php
              // SQL query to fetch state data
              $sql = "SELECT state FROM `indian_states` WHERE id = $state_id";
              $result = $conn->query($sql);
              if ($result->num_rows > 0) {
                  $state = $result->fetch_assoc();
                  echo $state['state'];
              }
              ?>
            </p>
          </div>
          <div class="mb-3">
            <label for="description">Description: </label>
            <p><?php echo $description; ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<style>
    label{
        font-weight: bold;
    }
    label+p{
        display: inline-block;
    }
</style>
<?php
include 'footer.php';
?>
