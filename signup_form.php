<?php
if(isset($_GET['error'])) { 
   echo 'Error Signup!';
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <title> Picsel - Sign Up </title>
    <meta charset="UTF-8" />
    <link href="css/signup.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" />
    <script defer src="./assets/fontawesome/js/solid.js"></script>
    <script defer src="./assets/fontawesome/js/fontawesome.js"></script>
</head>

<body>
    <div class="signup">
        <p class="text">Sign Up</p>
        <form class="signupform" action="./signup.php" method="post" name="signin_form">
            <label hidden for="nameid" class="namelabel">Name</label>
            <input class="name" name="name" id="nameid" type="text" placeholder="Name" />
            <label hidden for="usernameid" class="usernamelabel">Username</label>
            <input class="username" name="username" id="usernameid" type="text" placeholder="Username" />
            <span  class="usernameerror" name="usernameerror" id="usernameerror">Username non valido o già in uso</span>
            <label hidden for="emailid" class="emaillabel">Email</label>
            <input class="email" name="email" id="emailid" type="email" placeholder="Email" />
            <span  class="emailerror" name="emailerror" id="emailerror">Email non valida o già in uso</span>
            <label hidden for="passid" class="passwordlabel">Password</label>
            <input class="password" name="password" id="passid" type="password" placeholder="Password" />
            <span  class="passworderror" name="passworderror" id="passworderror">La password non contiene almeno 8 caratteri</span>
            <label hidden for="confirmpassid" class="confirmpasswordlabel">Confirm Password</label>
            <input class="confirmpassword" name="confirmpassword" id="confirmpassid" type="password" placeholder="Confirm Password" />
            <label hidden for="buttonid" class="buttonlabel"></label>
            <input type="submit" class="button" id="buttonid" value="Submit" />
        </form>
    </div>
</body>

</html>