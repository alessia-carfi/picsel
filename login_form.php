
<?php
if(isset($_GET['error'])) { 
   echo 'Error Logging In!';
}
?>

<form action="account/login.php" method="post" name="login_form">
   Email: <input type="text" name="email" /><br />
   Password: <input type="password" name="password" id="password"/><br />
   <input type="submit" value="Login"/>
</form>