<?php

# Set page title
$page_title = 'Add members';

# Include header
include 'includes/header.html';

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
  $err = [];

  # Connect to database
  mysqli_report(MYSQLI_REPORT_ALL | MYSQLI_REPORT_STRICT);
  $dbc = new mysqli("localhost", "despara", "enigma11", "attendance_app");

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
  $joined = empty($_POST['joined']) ? "-" : $_POST['joined'];

  # If everything is OK we should write to database

  if(empty($err)) {

    # Prepare query
    $stmt = $dbc->prepare("INSERT INTO users
                          (fname, lname, dob, joined, address, phone, generation)
                              VALUES(?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssi", $fname, $lname, $dob, $joined, $address, $phone, $gen);
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

<h1>This is Add members page</h1>

<div class="container">
  <div class="row">
    <div class="col-3 py-4">
      <form class="" action="add_members.php" method="POST">
        <div class="form-group my-1">
          <label for="fname" class="">First Name*</label>
          <input type="text" name="fname" id="fname" value=" <?php if (isset($fname)) echo $fname; ?>" class="form-control">
        </div>
        <div class="form-group my-1">
          <label for="lname" class="">Last Name*</label>
          <input type="text" name="lname" id="lname" value="<?php if (isset($lname)) echo $lname; ?>" class="form-control">
        </div>
        <div class="form-group my-1">
          <label for="dob" class="">Date of Birth*</label>
          <input type="date" name="dob" id="dob" value="<?php if (isset($dob)) echo $dob; ?>" class="form-control">
        </div>
        <div class="form-group my-1">
          <label for="joined" class="">Joined Date</label>
          <input type="date" name="joined" id="joined" value="<?php if (isset($joined)) echo $joined; ?>" class="form-control">
        </div>
        <div class="form-group my-1">
          <label for="address" class="">Address</label>
          <input type="text" name="address" id="address" value="<?php if (isset($address)) echo $address; ?>" class="form-control">
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


<!-- Include footer -->
<?php
include 'includes/footer.html';
?>



<!-- Database tables

CREATE TABLE users (
  user_id INT NOT NULL AUTO_INCREMENT,
  fname VARCHAR(30) NOT NULL,
  lname VARCHAR(30) NOT NULL,
  dob DATE,
  joined DATE,
  address VARCHAR(30),
  phone INT(30),
  generation INT,
  registered TIMESTAMP,
  PRIMARY KEY(user_id)
);

INSERT INTO users (fname, lname, dob, joined, address, phone, generation)
VALUES ('nikola', 'despic', '1986-12-15', '2018-2-18', 'some address 123', 32112336, 2013);

CREATE TABLE events (
  event_id INT NOT NULL AUTO_INCREMENT,
  generation INT NOT NULL,
  dt DATE NOT NULL,
  PRIMARY KEY(event_id)
);

CREATE TABLE staff (
  staff_id INT NOT NULL AUTO_INCREMENT,
  fname VARCHAR(30) NOT NULL,
  lname VARCHAR(30) NOT NULL,
  phone INT NOT NULL,
  leads INT
);






-->
