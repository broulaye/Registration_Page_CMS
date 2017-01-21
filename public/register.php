<?php
  require_once('../private/initialize.php');

  // Set default values for all variables the page needs.

  // if this is a POST request, process the form
  // Hint: private/functions.php can help

    // Confirm that POST values are present before accessing them.

    // Perform Validations
    // Hint: Write these in private/validation_functions.php

    // if there were no errors, submit data to database

      // Write SQL INSERT statement
      // $sql = "";

      // For INSERT statments, $result is just true/false
      // $result = db_query($db, $sql);
      // if($result) {
      //   db_close($db);

      //   TODO redirect user to success page

      // } else {
      //   // The SQL INSERT statement failed.
      //   // Just show the error, not the form
      //   echo db_error($db);
      //   db_close($db);
      //   exit;
      // }

?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>

  <?php
    // TODO: display any form errors here
    // Hint: private/functions.php can help
    $first_name = $_POST['FirstName'] ?? '';
    $last_name = $_POST['LastName'] ?? '';
    $email = $_POST['Email'] ?? '';
    $username = $_POST['Username'] ?? ''; 
    if(is_post_request()) {
      $array = array();
      $created_at = date("Y-m-d H:i:s");
      if($first_name == null || is_blank($first_name)){
        array_push($array, "First name cannot be blank.");
      }
      else if(!has_length($first_name, ['min' => 2, 'max' => 255])) {
        array_push($array, "First name must be between 2 and 255 characters.");
      }
      else if(!is_valid_name($first_name)) {
        array_push($array, "First name can only contains following values: letters, spaces, symbols(- , . ')");
      }
      else {
        $first_name = h($first_name);
      }

      if($last_name == null || is_blank($last_name)) {
        array_push($array, "Last name cannot be blank.");
      }
      else if(!has_length($last_name, ['min' => 2, 'max' => 255])) {
        array_push($array, "Last name must be between 2 and 255 characters.");
      }
      else if(!is_valid_name($last_name)) {
        array_push($array, "Last name can only contains following values: letters, spaces, symbols(- , . ')");
      }
      else {
        $last_name = h($last_name);
      }

      if($email == null || is_blank($email)) {
        array_push($array, "Email cannot be blank.");
      }
      else if(!has_valid_email_format($email)){
        array_push($array, "Email must be a valid format.");
      }
      else {
        $email = sanitize_email($email);
        $query = "SELECT email FROM users WHERE email='$email' limit 1";
        $val = db_num_rows(db_query($db, $query));
        if($val) {
          array_push($array, "Email already exist.");
        }
      }

      if($username == null || is_blank($username)) {
        array_push($array, "Username cannot be blank.");
      }
      else if((strlen($username) < 8)) {
        array_push($array, "Username must be at least 8 characters.");
      }
      else if(!is_valid_username($username)) {
        array_push($array, "Username can only contains following values: letters, numbers, symbols( _ )");
      }
      else {
        $username = h($username);
        //echo $username;
        $query = "SELECT username FROM users WHERE username='$username' limit 1";
        $val = db_num_rows(db_query($db, $query));
        if($val) {
          array_push($array, "Username already exist.");
        }
      }

      if(sizeof($array) > 0) {
        echo display_errors($array);
      }
      else {
        $sql = "INSERT INTO users (first_name, last_name, email, username, created_at)
          VALUES ('$first_name', '$last_name', '$email', '$username', '$created_at')";
        // For INSERT statments, $result is just true/false
        $result = db_query($db, $sql);
        if($result) {
           db_close($db);

            //redirect user to success page
           redirect_to('/registration_success.php');

        } else {
            // The SQL INSERT statement failed.
            // Just show the error, not the form
            echo db_error($db);
            db_close($db);
            exit;
        }
    }
      
    }
  ?>

  <!-- TODO: HTML form goes here -->
  <form action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    First name: <br></br><input type="text" name="FirstName" value = "<?php echo $first_name; ?>" /><br></br>
    Last name: <br></br><input type="text" name="LastName" value = "<?php echo $last_name; ?>" /><br></br>
    Email: <br></br><input type="text" name="Email" value = "<?php echo $email ?>" /><br></br>
    Username: <br></br><input type="text" name="Username" value = "<?php echo $username ?>"/><br></br>
    <input type="submit" name="Submit"/>
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
