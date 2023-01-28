<?php

# Set page title
$page_title = 'Edit Staff';

# Include header
include 'includes/header.html';

# Include credentials
include 'conf.php';

echo '<h1>This is a EDIT STAFF page</h1>';

# ID validation check

if(isset($_GET['id']) and is_numeric($_GET['id'])) { // from view_staff.php
  $id = $_GET['id'];
} elseif (isset($_POST['id']) and is_numeric($_POST['id'])) { // For editing member
  $id = $_POST['id'];
} else { // Invalid ID, stop the script
  echo '<p>This page has been accessed in error</p>';
  include 'includes/footer.html';
  exit();
}

# Database connection

$dbc = @mysqli_connect('localhost', "$un", "$pw", 'attendance_app');

# POST method check

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  # Check if first name is entered

  if(empty($_POST['fname'])) {
    $err[] = "You forgot to enter your first name!";
  } else {
    $fname = mysqli_real_escape_string($dbc, trim($_POST['fname']));
  }


  # Check if last name is entered

  if(empty($_POST['lname'])) {
    $err[] = "You forgot to enter your last name!";
  } else {
    $lname = mysqli_real_escape_string($dbc, trim($_POST['lname']));
  }


  # Check to see if generation is entered

  if(empty($_POST['generation'])) {
    $err[] = "You forgot to enter generation group!";
  } else {
    $gen = mysqli_real_escape_string($dbc, trim($_POST['generation']));
  }

  # Cheeck to see if phone number is entered

  if(empty($_POST['phone'])) {
    $err[] = "You forgot to enter phone number!";
  } else {
    $phone = mysqli_real_escape_string($dbc, trim($_POST['phone']));
  }


# Check if any errors

if(empty($err)) { // Everything OK
  # Create query
  $q = "UPDATE staff SET fname='$fname', lname='$lname',
  boss='$gen', phone='$phone' WHERE staff_id=$id";
  $r = @mysqli_query($dbc, $q);

  if(mysqli_affected_rows($dbc) == 1) { // If everything OK
    # Print message
    echo '<p>User updated!</p>';
    include 'includes/footer.html';
    exit();
  } else { // Not everything went OK
    # Print message
    echo '<p>Error occured, user not updated.</p>';
    echo '<p>Error: ' . mysqli_error($dbc) . '</p><br><p>Query: ' . $q . '</p>';
  }

} else { // Ran into some errors
    # Print errors
    foreach($err as $msg) {
      echo '<p>- ' . $msg . '</p>';
    }
    echo '<p>Please try again.';
  }
} // REQUEST METHOD if

# Fetch user info from DB

$q = "SELECT fname, lname, phone, boss FROM staff WHERE staff_id=$id";
$r = @mysqli_query($dbc, $q);

if (mysqli_num_rows($r) == 1) { // Valid ID
  # Get user info
  $row = mysqli_fetch_array($r, MYSQLI_ASSOC);

  # Print form
  echo '<form class="" action="edit_staff.php" method="POST">
        <p>First name: <input type="text" name="fname" value="' . $row['fname'] . '"></p>
        <p>Last name: <input type="text" name="lname" value="' . $row['lname'] . '"></p>
        <p>Phone: <input type="text" name="phone" value="' . $row['phone'] . '"></p>
        <p>Generation: <input type="text" name="generation" value="' . $row['boss'] . '"></p>
        <p><input class="form-control btn btn-dark" type="submit" name="submit" value="Submit"></p>
        <input type="hidden" name="id" value="' . $id . '"</p>
        </form>';


} else {
  echo '<p>Error, user ID is not valid.</p>';
}

mysqli_close($dbc);

?>



<!-- Include footer -->
<?php
include 'includes/footer.html';
?>
