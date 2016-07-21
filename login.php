<!DOCTYPE html>
<html>
    <head>
		<title> Log in </title>
		<meta charset="UTF-8">
    </head>
    <body>
		<nav id="menu">
			<?php
			include 'includes/menu.php';
			?>
		</nav>
		<hr>
		<h1>Log in</h1>
		<p><b>Please enter your details:</b></p>
		<form action="process.php" method="post">
		
			<label for="user">Username:</label><br>
			<input type="text" name="uname" id="user" />
			<br><br>
			<label for="user">Password:</label><br>
			<input type="password" name="pword" id="password"/>
			
		</form>		
		<br>
		<input type="submit"
		name="detailsubmit"
		value="Log in" />
		<br><br>
		<hr>
		<footer id="pagefooter">
			<p> Copyright &copy; 2016</p>
		</footer>
		<hr>
    </body>
</html>
