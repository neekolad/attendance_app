<?php

# Set page title
$page_title = 'Delete staff';

# Include credentials
include 'conf.php';


# Include header
include 'includes/header.html';

echo '<h1>This is a DELETE STAFF page</h1>';

# ID validation check
if (isset($_GET['id']) and is_numeric($_GET['id'])) { // From view_staff.php
  $id = $_GET['id'];
} elseif (isset($_POST['id']) and is_numeric($_POST['id'])) { // For erasing member
  $id = $_POST['id'];
} else { // Non valid ID
  echo '<p>This page has been accessed in error</p>';
  include 'includes/footer.html';
  exit();
}

# Database connection
$dbc = @mysqli_connect('localhost', "$un", "$pw", 'attendance_app');

# Checking for post method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if ($_POST['sure'] == 'Yes') {

    # Make a query
    $q = "DELETE FROM staff WHERE staff_id=$id";
    $r = @mysqli_query($dbc, $q);

    # Checking result
    if (mysqli_affected_rows($dbc) == 1) { // Query went OK
      echo '<p>User has been DELETED</p>';
    } else { // Query didnt go right
      echo '<p>An error occured, user couldnt be deleted.</p>';
      echo '<p>Error: ' . mysqli_error($dbc) . '</p><br> <p> Query: ' . $q . '</p>';
    }
  } else { // Deletion not confirmed
    echo '<p>The user has not been deleted.';
  }
} else { // If method not POST, make the form
  # Get staff info
  $q = "SELECT fname, lname FROM staff WHERE staff_id = $id";
  $r = @mysqli_query($dbc, $q);

  if (mysqli_affected_rows($dbc) == 1) { // If ID is valid, get info
    $row = mysqli_fetch_array($r, MYSQLI_ASSOC);

    # Show data to be erased
    echo '<p>Name: ' . $row['fname'] . ', ' . $row['lname'] . '</p>';
    echo '<p>Are you sure you want to delete this account?';

    # Make a form
    echo '<form action="delete_staff.php" method="post">
    <input type="radio" name="sure" value="Yes">Yes
    <input type="radio" name="sure" value="No">No
    <input type="submit" name="submit" value="submit">
    <input type="hidden" name="id" value=" '. $id . '">
    </form>
    ';
  } else { // ID not valid
    echo '<p>This page has errors</p>';
  }
} // End of if POST
mysqli_close($dbc);
?>




<!-- Include footer -->
<?php
include 'includes/footer.html';
?>
