<?php
include 'header.php';
?>

<div class="d-flex justify-content-end my-1">
  <a href="add.php" class="btn btn-primary">
    <span class="d-inline ">
      <i class="bx bx-plus"></i> <!-- Replace with the appropriate Boxicons class -->
    </span>
    <span class="d-none d-md-inline">Add</span>
  </a>
</div>

<div class="table-container col-12 ">
  <table id="people-table" class="table table-responsive table-bordered table-scroll">
    <thead>
      <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Phone Number</th>
        <th>Email</th>
        <th>Date of Birth</th>
        <th>Gender</th>
        <th>Skills</th>
        <th>Select your State</th>
        <th>Description</th>
        <th>Image</th>
        <th>Áction</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // SQL query to fetch data from the "people" table with JOIN operations
      $sql = "SELECT 
                        p.id,
                        p.first_name, 
                        p.last_name, 
                        p.phone_number, 
                        p.email, 
                        p.dob, 
                        g.gender, 
                        p.skills_id, 
                        s.state, 
                        p.description, 
                        p.profile_image 
                    FROM people p
                    LEFT JOIN gender g ON p.gender_id = g.id
                    LEFT JOIN indian_states s ON p.state_id = s.id";

      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row["first_name"] . "</td>";
          echo "<td>" . $row["last_name"] . "</td>";
          echo "<td>" . $row["phone_number"] . "</td>";
          echo "<td>" . $row["email"] . "</td>";
          echo "<td>" . $row["dob"] . "</td>";
          echo "<td>" . $row["gender"] . "</td>";
          // Decode the JSON array in the "skills_id" field
          $skillsArray = json_decode($row["skills_id"], true);

          if ($skillsArray) {
            // Initialize an array to store skill names
            $skillNames = array();

            // Loop through the skills and fetch their names
            foreach ($skillsArray as $skillId) {
              // Assuming you have a table named "skills" with "id" and "skill_name" columns
              // You can fetch the skill names from the "skills" table based on the IDs
              $sqlSkills = "SELECT skill_name FROM skills WHERE id = $skillId";
              $resultSkills = $conn->query($sqlSkills);
              if ($resultSkills->num_rows > 0) {
                $rowSkills = $resultSkills->fetch_assoc();
                $skillNames[] = $rowSkills["skill_name"];
              }
            }

            // Display skill names with commas
            echo "<td>" . implode(", ", $skillNames) . "</td>";
          } else {
            echo "<td>No skills</td>";
          }

          echo "<td>" . $row["state"] . "</td>";
          echo "<td>" . $row["description"] . "</td>";
          echo "<td><img class='table-sm-image' src='" . $row["profile_image"] . "' onclick=\"openImageInNewTab('" . $row["profile_image"] . "')\"></td>";
          echo "<td >
          <a href='view.php?id=".$row["id"]."' role='button' class='btn btn-success display-inline-block m-1' data-bs-toggle='tooltip' data-bs-placement='top' title='View'>"
        ?>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
  <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
  <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
</svg>


        <?php
       echo  "
        </a>
          <a href='edit.php?id=".$row["id"]."' role='button' class='btn btn-warning text-white display-inline-block m-1'  data-bs-toggle='tooltip' data-bs-placement='top' title='Edit'>
          <i class='bx bx-pencil'></i> 
        </a>
        <a href='delete_db.php?id=".$row['id']."&csrf_token=". $csrfToken."' class='btn btn-danger text-white display-inline-block m-1' data-bs-toggle='tooltip' data-bs-placement='top' title='Delete'>
        <i class='bx bx-trash-alt'></i> 
      </a>
        </td>";
          echo "</tr>";
        
        }
      } else {
        echo "<tr>";
        echo "<td colspan='10' class='text-center'>No records found.</td>";
        echo "</tr>";
      }

      $conn->close();
      ?>
    </tbody>
  </table>
</div>

</div>
</div>
<script>
  function openImageInNewTab(imageUrl) {
    window.open(imageUrl, '_blank');
  }
 

</script>

<?php
include 'footer.php';
?>