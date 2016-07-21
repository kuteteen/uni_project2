<!DOCTYPE html>
<html>
    <head>
		<title> Register </title>
		<meta charset="UTF-8">
    </head>
    <body>
		<nav id="menu">
			<?php
			include 'includes/menu.php';
			?>
		</nav>
		<hr>
		<h1>Register</h1>
		<p><b>Please enter your details:</b></p>
		<form action="process.php" method="post">
		
			<label for="user">First Name:</label><br>
			<input type="text" name="fname" id="fname" />
			<br><br>
			<label for="user">Last Name:</label><br>
			<input type="text" name="lname" id="lname" />
			<br><br>
			<label for="user">E-mail:</label><br>
			<input type="email" name="email" id="email" />
			<br><br>
			<label for="user">Username:</label><br>
			<input type="text" name="uname" id="uname" />
			<br><br>
			<label for="user">Password:</label><br>
			<input type="password" name="pword" id="pword"/>
			<br><br>
			<label for="user">Re-enter Password:</label><br>
			<input type="password" name="rpword" id="rpword"/>
		
		</form>		
		<br>
		<input type="submit"
		name="detailsubmit"
		value="Submit" />
		<br><br>
		<hr>
		<footer id="pagefooter">
			<p> Copyright &copy; 2016</p>
		</footer>
		<hr>
    </body>
</html>