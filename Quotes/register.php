<!--
This page provides a form to register a new account in the user database.

File name register.php 
    
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
if ( isset ( $_SESSION ['regError'] )) {
    $htmlToAdd = '<br><br><b>User name taken</b><br><br>';
}
?>

<h2>Register</h2>

<div>
	<form class="loginRegister" action="controller.php" method="post">
		<input type="text" id="userReg" name="userReg" placeholder="Username" required><br><br>
		<input type="password" id="passReg" name="passReg" placeholder="Password" required><br><br>
		<input type="submit" name="register" value="Register">
		<?php 
		echo $htmlToAdd;
		?>
	</form>
</div>

</body>
</html>