<?php

# Set page title
$page_title = 'View members';

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

$q = "SELECT * FROM users";
$r = @mysqli_query($dbc, $q);

if (mysqli_num_rows($r) > 0) {

$tbl = '<table class="table table-light table-striped table-hover table-bordered table-sm text-center">
          <thead>
            <tr>
              <th>' . 'ID' .'</th>
              <th>' . 'First Name' .'</th>
              <th>' . 'Last Name' .'</th>
              <th>' . 'Date of Birth' .'</th>
              <th>' . 'Date joined' .'</th>
              <th>' . 'Address' .'</th>
              <th>' . 'Phone no' .'</th>
              <th>' . 'Group' .'</th>
              <th>' . 'Registered' .'</th>
              <th>' . 'Edit' .'</th>
              <th>' . 'Remove' .'</th>
            </tr>
          </thead>
          <tbody>';

  # Output data of each row
  while ($row = mysqli_fetch_assoc($r)) {

      $tbl.='<tr>
              <td>' . $row['user_id'] . '</td>
              <td>' . $row['fname'] . '</td>
              <td>' . $row['lname'] . '</td>
              <td>' . $row['dob'] . '</td>
              <td>' . $row['joined'] . '</td>
              <td>' . $row['address'] . '</td>
              <td>' . $row['phone'] . '</td>
              <td>' . $row['generation'] . '</td>
              <td>' . $row['registered'] . '</td>
              <td><a href="edit_members.php?id=' . $row['user_id'] . '">Edit</td>
              <td><a href="delete_members.php?id=' . $row['user_id'] . '">Delete</td>
            </tr>';

  }
  $tbl.='</tbody></table>';
}
?>

<h1 class="my-3">This is a VIEW MEMBERS page</h1>

<div class="container">
  <div class="row">
    <div class="col-2 my-3">
      <button type="button" name="button" class="btn btn-dark"><a class="text-decoration-none text-light" href="add_members.php">Add members</a></button>
    </div>

    <div class="col-3 my-3">
      <label for="dropgen">Filter by generation</label>
      <select class="" name="dropgen">
        <option value="2010">2010</option>
        <option value="2011">2011</option>
        <option value="2012">2012</option>
        <option value="2013">2013</option>
        <option value="2014">2014</option>
        <option value="2015">2015</option>
        <option value="2016">2016</option>
        <option value="2017">2017</option>
      </select>
      </div>
  </div>


</div>


<?php echo $tbl; ?>




<!-- Include footer -->
<?php
include 'includes/footer.html';
?>
