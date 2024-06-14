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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
    <link href="css/login.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" />
</head>

<body class="login">
    <header>
        <h1 class="logintext">Login</h1>
    </header>
    <form class="loginform" id="loginform" action="./login.php" method="post" name="login_form">
        <label hidden for="emailid" class="emaillabel">E-mail</label>
        <input class="emaillg" name="email" id="emailid" type="text" placeholder="E-mail" />
        <label hidden for="passid" class="passwordlabel">Password</label>
        <input class="passwordlg" name="password" id="passid" type="password" placeholder="Password" />
        <span class="passworderrorlg" id="passworderrorid">Password doesn't match</span>
        <label hidden for="loginbuttonid">Submit</label>
        <input type="submit" class="loginbutton" id="loginbuttonid" value="Submit" />
    </form>
    <p class="donthaveaccount">
        <span class="textaccount">Don't you have an account? </span>
        <a title="Sign up" href="signup.php" class="signintext">Sign up</a>
    </p>
    <script type="module" src="./js/login.js"></script>
</body>

</html>