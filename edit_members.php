<?php

# Set page title
$page_title = 'Edit members';

# Include header
include 'includes/header.html';

echo '<h1>This is a EDIT MEMBERS page</h1>';

# ID validation check

if(isset($_GET['id']) and is_numeric($_GET['id'])) { // from view_users.php
  $id = $_GET['id'];
} elseif (isset($_POST['id']) and is_numeric($_POST['id'])) { // For editing member
  $id = $_POST['id'];
} else { // Invalid ID, stop the script
  echo '<p>This page has been accessed in error</p>';
  include 'includes/footer.html';
  exit();
}

# Database connection

$dbc = @mysqli_connect('localhost', 'despara', 'enigma11', 'attendance_app');

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

  # Check if date of birth is entered

  if(empty($_POST['dob'])) {
    $err[] = "You forgot to enter your date of birth!";
  } else {
    $dob = mysqli_real_escape_string($dbc, $_POST['dob']);
  }

  # Check to see if generation is entered

  if(empty($_POST['gen'])) {
    $err[] = "You forgot to enter generation group!";
  } else {
    $gen = mysqli_real_escape_string($dbc, trim($_POST['gen']));
  }

  # Cheeck to see if phone number is entered

  if(empty($_POST['phone'])) {
    $err[] = "You forgot to enter phone number!";
  } else {
    $phone = mysqli_real_escape_string($dbc, trim($_POST['phone']));
  }

  $address = empty($_POST['address']) ? "N/A" : $_POST['address'];
  $joined = empty($_POST['joined']) ? "2018-2-20" : $_POST['joined'];

# Check if any errors

if(empty($err)) { // Everything OK
  # Create query
  $q = "UPDATE users SET fname='$fname', lname='$lname', dob='$dob',
  generation='$gen', phone='$phone', address='$addess', joined='$joined' WHERE user_id=$id";
  $r = @mysqli_query($dbc, $q);

  if(mysqli_affected_rows($dbc) == 1) { // If everything OK
    # Print message
    echo '<p>User updated!</p>';
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

$q = "SELECT fname, lname, dob, generation, phone, address, joined FROM users WHERE user_id=$id";
$r = @mysqli_query($dbc, $q);

if (mysqli_num_rows($r) == 1) { // Valid ID
  # Get user info
  $row = mysqli_fetch_array($r, MYSQLI_ASSOC);

  # Print form
  echo '<form class="" action="edit_members.php" method="POST">
        <p>First name: <input type="text" name="fname" value="' . $row['fname'] . '"></p>
        <p>Last name: <input type="text" name="lname" value="' . $row['lname'] . '"></p>
        <p>Date of birth: <input type="date" name="dob" value="'. $row['dob'] . '"></p>
        <p>Date joined: <input type="date" name="joined" value="' . $row['joined'] . '"></p>
        <p>Address: <input type="text" name="address" value="' . $row['address'] . '"></p>
        <p>Phone: <input type="text" name="phone" value="' . $row['phone'] . '"></p>
        <p>Generation: <input type="text" name="generation" value="' . $row['generation'] . '"></p>
        <p><input class="form-control btn btn-dark" type="submit" name="submit" value="Submit"></p>
        <input type="hidden" name="id" value="' . $id . '"
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
