<!--
This page provides a form for a to login to the user database.

File name login.php 
    
Authors: Brennan Mitchell
-->

<!DOCTYPE html>
<html>
<head>
<title>Add Quote</title>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<?php 
session_start();
$htmlToAdd = '';
if ( isset ( $_SESSION ['invalidInput'] )) {
    $htmlToAdd = '<br><br><b>Invalid Username and/or Password</b><br><br>';
}
?>

<h2>Login</h2>

<div>
	<form class="loginRegister" action="controller.php" method="post">
		<input type="text" id="userLog" name="userLog" placeholder="Username" required><br><br>
		<input type="password" id="passLog" name="passLog" placeholder="Password" required><br><br>
		<input type="submit" name="login" value="Login">
		<?php 
		echo $htmlToAdd;
		?>
	</form>
</div>

</body>
</html>