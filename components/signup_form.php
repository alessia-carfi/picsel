<?php
if (isset($_GET['error'])) {
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
        <form class="signupform" action="" id="signupform" method="post">
            <label hidden for="name" class="namelabel">Name</label>
            <input class="name" name="name" id="name" type="text" placeholder="Name" />
            <span class="nameerror" id="nameerror">Name not valid</span>
            <label hidden for="username" class="usernamelabel">Username</label>
            <input class="username" name="username" id="username" type="text" placeholder="Username" />
            <span class="usernameerror" id="usernameerror">Username not valid</span>
            <label hidden for="email" class="emaillabel">Email</label>
            <input class="email" name="email" id="email" type="email" placeholder="Email" />
            <span class="emailerror" id="emailerror">Email not valid</span>
            <label hidden for="password" class="passwordlabel">Password</label>
            <input class="password" name="password" id="password" type="password" placeholder="Password" />
            <span class="passworderror" id="passworderror">Password should be at least 8 characters long</span>
            <label hidden for="confirmpassword" class="confirmpasswordlabel">Confirm Password</label>
            <input class="confirmpassword" name="confirmpassword" id="confirmpassword" type="password" placeholder="Confirm Password" />
            <span class="confirmpassworderror" id="confirmpassworderror">Passwords do not match</span>
            <label hidden for="button" class="buttonlabel"></label>
            <input type="submit" class="button" id="button" value="Submit" />
        </form>
    </div>
    <script type="text/javascript" src="./js/signup.js"></script>
</body>

</html>