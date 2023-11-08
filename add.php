<?php
include 'header.php';
?>


<div class="container">
  <h5 class="text-center">Add Person</h1>
  <div class="row justify-content-center">
    <div class="col-md-10 mt-2">
      
  <form id="add-person-form" action="add_db.php" method="post" enctype="multipart/form-data">
  <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
    <div class="row justify-content-center">
    <div class="avatar-upload ">
        <div class="avatar-edit">
            <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg"   name="profile_image" required />
            <label for="imageUpload"></label>
        </div>
        <div class="avatar-preview">
            <div id="imagePreview" style="background-image: url(https://2.bp.blogspot.com/-l9nGy2e3PnA/XLzG5A6u_cI/AAAAAAAAAgI/31bl8XZOrTwN0kTN8c18YOG3OhNiTUrsQCLcBGAs/s1600/rocket.png);">
            </div>
        </div>
    </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="mb-3">
          <label for="first_name">First Name<span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="first_name" name="first_name" required placeholder="Enter Your First Name...">
        </div>
      </div>
      <div class="col-md-6">
      <div class="mb-3">
        <label for="last_name">Last Name<span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="last_name" name="last_name" required placeholder="Enter Your Last Name...">
      </div>
      </div>
      <div class="col-md-6">
      <div class="mb-3">
        <label for="phone_number">Phone Number<span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="phone_number" name="phone_number" required placeholder="Enter Your Phone Number...">
      </div>
      </div>
      <div class="col-md-6">
      <div class="mb-3">
        <label for="email">Email<span class="text-danger">*</span></label>
        <input type="email" class="form-control" id="email" name="email" required placeholder="Enter Your Email...">
      </div>
      </div>
      <div class="col-md-6">
      <div class="mb-3">
        <label for="dob">Date of Birth<span class="text-danger">*</span></label>
        <input type="date" class="form-control" id="dob" name="dob" required>
      </div>
      </div>
      <div class="col-md-6">
      <div class="mb-3">
    <label for="gender">Gender<span class="text-danger">*</span></label>
    <div class="d-flex flex-wrap gap-4 radio-inputs">
 
    <?php
    // SQL query to fetch data from the "gender" table
    $sql = "SELECT * FROM `gender`";

    // Execute the query
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<label class="form-check radio ps-0">';
            echo '<input class="form-check-input" type="radio" name="gender" id="gender-' . $row['id'] . '" value="' . $row['id'] . '">';
            echo '<span class="name" for="gender-' . $row['id'] . '">' . $row['gender'] . '</label>';
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
    // SQL query to fetch data from the "skills" table (you should replace 'skills' with the actual table name)
    $sql = "SELECT * FROM `skills`";

    // Execute the query
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<label class="form-check radio ps-0">';
            echo '<input class="form-check-input" type="checkbox" name="skills[]" id="skills-' . $row['id'] . '" value="' . $row['id'] . '">';
            echo '<span class="name" for="skills-' . $row['id'] . '">' . $row['skill_name'] . '</label>';
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
        <label for="state"> State<span class="text-danger">*</span></label>

        <select class="form-control js-example-basic-single" id="state" name="state" required>
        <option value="" selected disabled> Select Your State </option>
        <?php
        // Include the database connection
        include 'config.php';

        // SQL query to fetch data from the "indian_states" table
        $sql = "SELECT * FROM `indian_states`";

        // Execute the query
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['id'] . '">' . $row['state'] . '</option>';
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
        <textarea class="form-control" id="description" name="description" required></textarea>
      </div>
    </div>
    </div>
   

<div class="mb-3">
  <button type="submit" class="btn btn-primary">Add Person</button>
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