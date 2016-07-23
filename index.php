<?php
//Use of sessions to maintain state.
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
		<title>Home</title>
		<meta charset="UTF-8">
    </head>
    <body>
		<nav id="menu">
			<?php
			//Main navigation menu
			include 'includes/menu.php';
			?>
		</nav>
		<hr>
		<?php
		//Block of code to display a thank you message after successful registration.
		if (isset($_SESSION['registration_success']) && $_SESSION['registration_success'] === true ) {
			echo '<p>Thank you! Your registration is now complete.</p>
			<a href="loginform.php?'. SID .'"> Click here to Log in </a><hr>';
			unset($_SESSION['registration_success']);
		}
		//Successful log out message
		if (isset($_GET['logout_success']) && $_GET['logout_success'] == true ) {
			echo '<p>You have been logged out.</p><hr>';
			unset($_GET['logout_success']);
		}
		?>
		<h1>Welcome!</h1>
		<h2>Today's poem:</h2>
		<p>
			<b>Where the Sidewalk Ends</b>
			<br><br>
			There is a place where the sidewalk ends<br>
			And before the street begins,<br>
			And there the grass grows soft and white,<br>
			And there the sun burns crimson bright,<br>
			And there the moon-bird rests from his flight<br>
			To cool in the peppermint wind.<br>
			<br>
			Let us leave this place where the smoke blows black<br>
			And the dark street winds and bends.<br>
			Past the pits where the asphalt flowers grow<br>
			We shall walk with a walk that is measured and slow,<br>
			And watch where the chalk-white arrows go<br>
			To the place where the sidewalk ends.<br>
			<br>
			Yes we'll walk with a walk that is measured and slow,<br>
			And we'll go where the chalk-white arrows go,<br>
			For the children, they mark, and the children, they know<br>
			The place where the sidewalk ends.<br>
			<br>
			<b>Shel Silverstein</b>
			<br>
		</p>
		<hr>
		<footer id="pagefooter">
			<p> Copyright &copy; 2016</p>
		</footer>
		<hr>
    </body>
</html>
