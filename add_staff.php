<?php

# Set page title
$page_title = 'Add Staff';

# Include header
include 'includes/header.html';

# Include credentials
include 'conf.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
  $err = [];

  # Connect to database
  mysqli_report(MYSQLI_REPORT_ALL | MYSQLI_REPORT_STRICT);
  $dbc = new mysqli("localhost", "$un", "$pw", "attendance_app");

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

  if(empty($_POST['gen'])) {
    $err[] = "You forgot to enter generation group!";
  } else {
    $gen = mysqli_real_escape_string($dbc, trim($_POST['gen']));
  }

  # Check to see if phone number is entered

  if(empty($_POST['phone'])) {
    $err[] = "You forgot to enter phone number!";
  } else {
    $phone = mysqli_real_escape_string($dbc, trim($_POST['phone']));
  }


  # If everything is OK we should write to database

  if(empty($err)) {

    # Prepare query
    $stmt = $dbc->prepare("INSERT INTO staff
                          (fname, lname, phone, boss)
                              VALUES(?,?,?,?)");
    $stmt->bind_param("ssss", $fname, $lname, $phone, $gen);
    $stmt->execute();

    if ($stmt) {
      echo '<h3>Insert succesful!</h3>';
    } else {
      echo '<h3>You could not be registered due to the system error</h3>';
    }

    include 'includes/footer.html';
    exit();

  } else {
    # Printing errors
    foreach($err as $msg) {
      echo '<p class="text-danger"> - ' . $msg .  '</p>';
    }
  }

} # End if POST
?>

<h1>This is Add staff page, you can add coaches here.</h1>

<div class="container">
  <div class="row">
    <div class="col-3 py-4">
      <form class="" action="add_staff.php" method="POST">
        <div class="form-group my-1">
          <label for="fname" class="">First Name*</label>
          <input type="text" name="fname" id="fname" value=" <?php if (isset($fname)) echo $fname; ?>" class="form-control">
        </div>
        <div class="form-group my-1">
          <label for="lname" class="">Last Name*</label>
          <input type="text" name="lname" id="lname" value="<?php if (isset($lname)) echo $lname; ?>" class="form-control">
        </div>
        <div class="form-group my-1">
          <label for="phone" class="">Phone*</label>
          <input type="text" name="phone" id="phone" value="<?php if (isset($phone)) echo $phone; ?>" class="form-control">
        </div>
        <div class="form-group my-1">
          <label for="gen" class="">Generation*</label>
          <select class="form-control" name="gen" id="gen">
            <option value="" disabled selected>Select an option</option>
            <option value="2018">2018</option>
            <option value="2017">2017</option>
            <option value="2016">2016</option>
            <option value="2015">2015</option>
            <option value="2014">2014</option>
            <option value="2013">2013</option>
            <option value="2012">2012</option>
          </select>
        </div>
        <div class="form-group my-4">
          <button type="submit" name="submit" value="Submit" class="form-control btn btn-dark">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
