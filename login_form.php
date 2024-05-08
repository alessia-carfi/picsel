<?php
if(isset($_GET['error'])) { 
   echo 'Error Logging In!';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title> Picsel - Login </title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
    <link href="css/login.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" />
</head>

<body>
    <div class="login">
        <p class="logintext">Login</p>
        <form class="loginform" action="./login.php" method="post" name="login_form">
            <label hidden for="emailid" class="emaillabel">E-mail</label>
            <input class="emaillg" name="email" id="emailid" type="text" placeholder="E-mail" />
            <label hidden for="passid" class="passwordlabel">Password</label>
            <input class="passwordlg" name="password" id="passid" type="password" placeholder="Password" />
            <label hidden for="loginbuttonid">Submit</label>
            <input type="submit" class="loginbutton" id="loginbuttonid" value="Submit" />
        </form>
        <p class="donthaveaccount">
            <span class="textaccount">Don't you have an account? </span>
            <a href="signup.php" class="signintext">Sign Up</a>
        </p>
    </div>
</body>

</html>