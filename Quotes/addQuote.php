<!--
This page provides a form for a user to add a new quote to view.php.

File name addQuote.php 
    
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
session_start()
?>

<h2>Add a Quote</h2>

<div>
	<form class="addQuote" action="controller.php" method="post">
		<textarea id="quote" name="quote" rows="4" cols="50" placeholder="Enter new quote"></textarea><br>
		<input type="text" id="author" name="author" placeholder="Author"><br><br>
		<input type="submit" name="Add Quote">
	</form>
</div>

</body>
</html>