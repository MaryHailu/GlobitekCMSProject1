<!DOCTYPE HTML>
<html>
<head>
</head>
<body>

<?php
     require_once('../private/initialize.php');

       // define variable
      $fname = $lname = $email = $uname = "";
      $fnameErr = $lnameErr = $emailErr = $unameErr = "";
      $options = array('min' =>2, 'max' => 255);
      $success_page = 'registration_success.php';

       // cheack post request
        if(is_post_request()){
           //First Name
           if((is_blank($_POST["fname"]) === true)){

              $fnameErr = "First name cannot be blank.";
            }
           elseif (has_length(($_POST["fname"]), 255) === true) {

              $fnameErr = "First name must be between 2 and 255 characters";
            }
           else{
              $fname = test_input($_POST["fname"]);
            }

            //Last Name
           if((is_blank($_POST["lname"]) === true)){

              $lnameErr = "Last name cannot be blank.";
            }
           elseif (has_length(($_POST["lname"]), 255) === true) {
               
              $lnameErr = "Last name must be between 2 and 255 characters";
            }
           else{
               $lname = test_input($_POST["lname"]);
            }
            // Email

            if((has_valid_email_format($_POST["email"])) === false){
              // echo "Email must be a valid format";
              $emailErr = "Email must be a valid format";
            }
            else{
              $email = test_input($_POST["email"]);
            }

            // Username

            if((username_haslength($_POST["uname"])) === true){
              // echo "Username must be at least 8 characters";
              $unameErr = "Username must be at least 8 characters";
            }
            else{
              $uname = test_input($_POST["uname"]);
            }
          }

?>



<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>


<div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>

  <div>
    <div>
  <?php
    echo "\t\t"."<ul>\n";
    if($fnameErr or $lnameErr or $unameErr or $emailErr){
    echo "Please fix the following errors:";
      if($fnameErr){
        echo "\t\t"."\t<li>$fnameErr</li>\n";
      }
      if($lnameErr){
        echo "\t\t"."\t<li>$lnameErr</li>\n";
      }
      if($unameErr){
        echo "\t\t"."\t<li>$unameErr</li>\n";
      }
      if($emailErr){
        echo "\t\t"."\t<li>$emailErr</li>\n";
      }
    }
    if($fname and $lname and $uname and $email){
      //echo "all are correct";
      $current_dt = date("Y-m-d H:i:s");

      $sql = "INSERT INTO users (fname, lname, email, uname, created_at)
      VALUES ('$fname', '$lname', '$email', '$uname', '$current_dt')";

      $result = db_query($db, $sql);
      if($result){
        db_close($db);
        header("Location: {$success_page}");
        exit;
      }
      else{
        echo h(db_error($db));
        db_close($db);
        exit;
      }

    }
   echo "\t\t"."</ul>\n";
  ?>
   </div>
 </div>


  <?php
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  ?>

  <!-- TODO: HTML form goes here -->
  <form action='register.php' method="POST">
   First Name:
  <BR><INPUT TYPE = TEXT NAME = "fname" SIZE=20 value="<?php echo h($fname); ?>"><BR>
  Last Name:
  <BR><INPUT TYPE = TEXT NAME = "lname" SIZE=20 value="<?php echo h($lname); ?>"><BR>
  Email:
  <BR><INPUT TYPE = TEXT NAME = "email" SIZE=20 value="<?php echo h($email); ?>"><BR>
  Username:
  <BR><INPUT TYPE = TEXT NAME = "uname" SIZE=20 value="<?php echo h($uname); ?>"><BR>
  <BR><INPUT TYPE='SUBMIT' VALUE='Submit!'><BR>
  </form>

</div>


<?php include(SHARED_PATH . '/footer.php'); ?>

</body>
</html>
