<?php
//Use of sessions to maintain state.
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
		<title>My Account</title>
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
		<h1>Account:</h1>
		<?php
		//Checks if the user is already logged in and generates account information based on user data file.
		if (isset($_SESSION['login_state']) && $_SESSION['login_state'] === true){
			$handle = fopen('data/userdata.txt', 'r');
			rewind($handle);
			while (!feof($handle)) {
				$parsedLine = explode(":",fgets($handle));
				if (count($parsedLine) > 1 && $parsedLine[1] === $_SESSION['username']) {
					$firstname = $parsedLine[9];
					$lastname = $parsedLine[11];
					$email = $parsedLine[7];
					$username = $parsedLine[1];
					$created = $parsedLine[5];
					fclose($handle);
					break;
				}
			}
			echo '<p>Username: '.$username.'
			<br>First name: '.$firstname.' 
			<br>Last name: '.$lastname.' 
			<br>E-mail address: '.$email.' 
			<br>Date created: '.$created.'</p><br>';
			unset($username,$firstname,$lastname,$email,$created);
		} else {
			//If the user isn't logged in, a short message is displayed asking to log in.
			echo '<p>You need to be logged in to view your account.</p>
			<a href="loginform.php?'. SID .'"> Click here to Log in </a>';
		}
		?>
		<hr>
		<footer id="pagefooter">
			<p> Copyright &copy; 2016</p>
		</footer>
		<hr>
    </body>
</html>

