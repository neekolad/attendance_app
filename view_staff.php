<?php

# Set page page title
$page_title = "Staff";

# Include header
include 'includes/header.html';

# Include credentials
include 'conf.php';

# Database connection
$dbc = @mysqli_connect('localhost', "$un", "$pw", 'attendance_app');

# Check connection
if (!$dbc) {
  die("Connection failed: " . mysqli_error());
}

$q = "SELECT * FROM staff";
$r = @mysqli_query($dbc, $q);

if (mysqli_num_rows($r) > 0) {

  $tbl = '<table class="table table-light table-striped table-hover table-bordered table-sm text-center">
            <thead>
              <tr>
                <th>' . 'ID' .'</th>
                <th>' . 'First Name' .'</th>
                <th>' . 'Last Name' .'</th>
                <th>' . 'Phone' .'</th>
                <th>' . 'Generation' .'</th>
                <th>' . 'Edit' .'</th>
                <th>' . 'Remove' .'</th>
              </tr>
            </thead>
            <tbody>';

  # Output data of each row
  while ($row = mysqli_fetch_assoc($r)) {

      $tbl.='<tr>
              <td>' . $row['staff_id'] . '</td>
              <td>' . $row['fname'] . '</td>
              <td>' . $row['lname'] . '</td>
              <td>' . $row['phone'] . '</td>
              <td>' . $row['boss'] . '</td>
              <td><a href="edit_staff.php?id=' . $row['staff_id'] . '">Edit</td>
              <td><a href="delete_staff.php?id=' . $row['staff_id'] . '">Delete</td>
              </tr>';
    }
  $tbl.='</tbody></table>';

} // end mysqlinumrows if
?>


<h1 class="my-3">This is a VIEW STAFF page</h1>
<p>Here you will see a list of staff. You can add, edit or delete a coach</p>

<div class="col-2 my-3">
  <button type="button" name="button" class="btn btn-dark"><a class="text-decoration-none text-light" href="add_staff.php">Add staff</a></button>
</div>

<?php echo $tbl; ?>


<?php
include 'includes/footer.html';
 ?>
