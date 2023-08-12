<!--
This form unsets the SESSION tag to log the user out of their account.

File name logout.php 
    
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
session_start ();
unset($_SESSION ['user']);
header ( "Location: view.php" );
?>


</body>
</html>