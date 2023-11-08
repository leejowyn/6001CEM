<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="login.css">
    <script src="https://kit.fontawesome.com/a84d485a7a.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>

<body>
    <?php
     $page = "";
     include "connect.php";

    $username = $email = $password = $gender = $dob = $address = "";
    $usernameErr = $emailErr = $passwordErr = $dobErr = $addressErr = $allErr = "";
    session_start();
    if (isset($_POST['register'])) {
  
      $username = ucwords(strtolower($_POST['username']));
      $email = $_POST['email'];
      $password = $_POST['password'];
      $gender = $_POST['gender'];
      $dob = $_POST['dob'];
      $address = $_POST['address'];

      //password validation
      $number = preg_match('@[0-9]@', $password);
      $upperCase = preg_match('@[A-Z]@', $password);
      $lowerCase = preg_match('@[a-z]@', $password);
      $specialChars = preg_match('@[^\w]@', $password);
      
      $okay = true;
      
        //username validation
         if (!ctype_alpha(str_replace(' ', '', $username))) {
          $usernameErr = "* Only letters and spaces are allowed". "<br>";
          $okay = false;
        }
  
        //email validation
         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                  $emailErr = "* Invalid E-mail address";
                  $okay = false;
              }
        else {
                  $query = "SELECT * FROM user WHERE email = '$email'";
  
                  if ($result = mysqli_query($db, $query)) {
                      if (mysqli_num_rows($result) == 1) {
                          $okay = false;
                          $emailErr = "* Email address is already in use."."<br>";
                          
                      }
                  }
                  else {
                      echo 'Error: '.mysqli_error($db);
                  }
              }
        
        //password validation
       if (strlen($password) < 8 || !$number || !$upperCase || !$lowerCase || !$specialChars) {
                  $passwordErr = "* Password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.". "<br>";
                  $okay = false;
                }
      if ($okay ) {
          $query = "INSERT INTO user (user_id, username, email, password, gender, dob, address)
          VALUES (0,'$username', '$email', '$password','$gender', '$dob', '$address')";
      
         if(mysqli_query($db, $query)) {
            
          $query= "SELECT * FROM user WHERE email = '$email'";
  
          if ($r = mysqli_query($db, $query)) {
            $row = mysqli_fetch_array($r);
            $_SESSION ['user_id'] = $row ['user_id'];
            //$_SESSION['user_id'] = "SELECT * FROM user WHERE email ='$email'";
            }
            else{
                echo mysqli_error($db);
            }
        }
        else {
            echo 'Error: '.mysqli_error($db);
        }
      }
  
      }

    $signinemailErr= $signinpasswordErr= "";
    $okay = true;
	
	if (isset($_POST['signin'])) {
        $signinemail = $_POST['signinemail'];
        $signinpassword = $_POST['signinpassword'];

        if (!filter_var($signinemail, FILTER_VALIDATE_EMAIL)) {
                $signinemailErr = "* Invalid E-mail address"."<br>";
                $okay = false;
            }

    if ($okay) {
        
        //retrieve and check whether this email and password is exist
        $query = "SELECT * FROM user WHERE email = '$signinemail'";

        if ($result = mysqli_query($db, $query)) {
            if (mysqli_num_rows($result) == 0) {
                $signinemailErr = "* Couldn't find that E-mail address. Check the spelling and try again.". "<br>";
                $okay = false;
            }
            else {
                $query = "SELECT * FROM user WHERE email='$signinemail' AND password ='$signinpassword'";
                if ($r = mysqli_query($db, $query)) {
                    if (mysqli_num_rows($r) > 0) {
                        $row = mysqli_fetch_array($r);
                        $_SESSION['user_id'] = $row['user_id'];

                        echo "<script>
                        window.setTimeout(function(){
                        window.location.href = 'index.html';
                        }, 100);
                    </script>";
                         }

                    else {
                        $signinpasswordErr = "The password that you've entered is incorrect. Please try again."."<br>";
                    }
                }
                 }
         }
        
        //close database
        mysqli_close($db);
    }
}
    ?>
    <br><br><br>
<div class="container" id="container">
	<div class="form-container sign-up-container">
		<form action="userlogin.php" method="post">
			<h1>Create Account</h1>
			<br>
            <?php
            echo $usernameErr ;
            echo $emailErr ;
            echo $passwordErr;
            echo $dobErr;
            echo $addressErr;
            ?>
			<input type="text" name="username" placeholder="Username" />
			<input type="email" name="email" placeholder="Email" />
			<input type="password" name="password" placeholder="Password" />
            <input type="date" name="dob" placeholder="Dob" />
            <input type="text" name="address" placeholder="Address" />
            <br>
            <div>
            <input type="radio" class="btn-check" name="gender" id="option1" value="male" checked>
            <label class="btn btn-secondary" for="option1">Male</label>
            <input type="radio" class="btn-check" name="gender" id="option2" value="female">
            <label class="btn btn-secondary" for="option2">Female</label>
            </div>
			<br>
			<button type="submit" name="register">Register</button>
		</form>
	</div>
	<div class="form-container sign-in-container">
		<form action="userlogin.php" method="post"> 
			<h1>Sign in</h1>
			<br>
            <?php
            echo $signinemailErr ;
            echo $signinpasswordErr ;
            ?>

			<input type="email" name="signinemail" placeholder="Email" />
			<input type="password" name="signinpassword" placeholder="Password" />
			<br>
			<button type="submit" name="signin">Sign In</button>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>Welcome Back!</h1>
				<p>To keep connected with us please login with your personal info</p>
				<button class="ghost" id="signIn">Sign In</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1>Hello, There!</h1>
				<p>Enter your personal details and start journey with us</p>
				<button class="ghost" id="signUp">Sign Up</button>
			</div>
		</div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>

<script>
    const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

signUpButton.addEventListener('click', () => {
	container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
	container.classList.remove("right-panel-active");
});
</script>

</html>