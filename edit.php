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
  <h5 class="text-center">Edit Person</h1>
  <div class="row justify-content-center">
    <div class="col-md-10 mt-2">
      <form id="edit-person-form" action="edit_db.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
        <div class="row justify-content-center">
          <div class="avatar-upload">
            <div class="avatar-edit">
              <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" name="profile_image" />
              <label for="imageUpload"></label>
            </div>
            <div class="avatar-preview">
              <div id="imagePreview" style="background-image: url('<?php echo $profile_image_path; ?>');">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="first_name">First Name<span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="first_name" name="first_name" required value="<?php echo $first_name; ?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label for="last_name">Last Name<span class="text-danger">*</span></label>
              <input type text" class="form-control" id="last_name" name="last_name" required value="<?php echo $last_name; ?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label for="phone_number">Phone Number<span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="phone_number" name="phone_number" required value="<?php echo $phone_number; ?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label for="email">Email<span class="text-danger">*</span></label>
              <input type="email" class="form-control" id="email" name="email" required value="<?php echo $email; ?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label for="dob">Date of Birth<span class="text-danger">*</span></label>
              <input type="date" class="form-control" id="dob" name="dob" required value="<?php echo $dob; ?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label for="gender">Gender<span class="text-danger">*</span></label>
              <div class="d-flex flex-wrap gap-4 radio-inputs">
                <?php
                // SQL query to fetch data from the "gender" table
                $sql = "SELECT * FROM `gender`";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $genderId = $row['id'];
                        $checked = $genderId == $gender_id ? 'checked' : '';
                        echo '<label class="form-check radio ps-0">';
                        echo "<input class='form-check-input' type='radio' name='gender' id='gender-$genderId' value='$genderId' $checked>";
                        echo '<span class="name" for="gender-' . $genderId . '">' . $row['gender'] . '</label>';
                        echo '</label>';
                    }
                } else {
                    echo '<p>No gender options available</p>';
                }
                ?>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label for="skills">Skills<span class="text-danger">*</span></label>
              <div class="d-flex flex-wrap gap-4 radio-inputs" id="skills-container">
                <?php
                // SQL query to fetch data from the "skills" table
                $sql = "SELECT * FROM `skills`";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $skillId = $row['id'];
                        $checked = in_array($skillId, $skills_ids) ? 'checked' : '';
                        echo '<label class="form-check radio ps-0">';
                        echo "<input class='form-check-input' type='checkbox' name='skills[]' id='skills-$skillId' value='$skillId' $checked>";
                        echo '<span class="name" for="skills-' . $skillId . '">' . $row['skill_name'] . '</label>';
                        echo '</label>';
                    }
                } else {
                    echo '<p>No skill options available</p>';
                }
                ?>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label for="state">State<span class="text-danger">*</span></label>
              <select class="form-control js-example-basic-single" id="state" name="state" required>
                <option value="" selected disabled> Select Your State </option>
                <?php
                // SQL query to fetch data from the "indian_states" table
                $sql = "SELECT * FROM `indian_states`";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $stateId = $row['id'];
                        $selected = $stateId == $state_id ? 'selected' : '';
                        echo "<option value='$stateId' $selected>" . $row['state'] . '</option>';
                    }
                } else {
                    echo '<option value="">No state options available</option>';
                }
                ?>
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="mb-3">
              <label for="description">Description<span class="text-danger">*</span></label>
              <textarea class="form-control" id="description" name="description" required><?php echo $description; ?></textarea>
            </div>
          </div>
        </div>
        <div class="mb-3">
          <button type="submit" class="btn btn-primary">Update Person</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
include 'footer.php';
?>
<script>
  // In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});
  function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload").change(function() {
    readURL(this);
});

</script>
