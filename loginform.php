<?php
//Use of sessions to maintain state.
session_start();
//Prevent output until certain that user hasn't logged in successfully (allows header change).
ob_start();
?>
<!DOCTYPE html>
<html>
    <head>
		<title>Log in</title>
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
		//Initializing variables
		$form_submitted = false;
		$user_match = false;
		
		$cleanInput = array();

		//Executes if form has been submitted.
		if (isset($_POST['loginsubmit'])) {
			$form_submitted = true;
			//Cleaning user input and adding it to a separate array.
			foreach ($_POST as $key => $value){
			$cleanInput[$key] = htmlentities(trim($value));
			}
			//Opening a file where user data is stored.
			$handle = fopen('data/userdata.txt', 'r');
			//Temporary variables to reduce typing.
			$username = $cleanInput['username'];
			$password = $cleanInput['password'];
			//If login details are present they are checked against the user data file.
			if (isset($username) && isset($password)) {
				rewind($handle);
				while (!feof($handle)) {
					$parsedLine = explode(":",fgets($handle));
					if (count($parsedLine) > 1 && $parsedLine[1] === $username && $parsedLine[3] === $password) {
						$user_match = true;
						break;
					}
				}	
			}
			fclose($handle);
			unset($username,$password,$parsedLine);
		}
		//Main form is displayed when nothing is submitted.
		if 	($form_submitted === false) {
			echo '<h1>Log in</h1>
			<p><b>Please enter your details:</b></p>';
			echo '<form action="loginform.php?'. SID .'" method="post">
			<label for="user">Username:</label><br>
			<input type="text" name="username" id="user"/>
			<br><br>
			<label for="password">Password:</label><br>
			<input type="password" name="password" id="pword"/>
			<br><br>
			<input type="submit"
			name="loginsubmit"
			value="Log in" />
			<br><br>
			</form>
			<a href="registerform.php?'. SID .'">Click here to register</a>';
		}
		//If login details have no match, the form is re-displayed together with username and error messages.
		if 	($form_submitted === true && $user_match === false) {
			echo '<h1>Log in</h1>
			<p><b>Please enter your details:</b></p>';
			echo "<p><b>Error:</b><br>* Invalid login details, please try again.</p>";
			echo '<form action="loginform.php?'. SID .'" method="post">
			<label for="user">Username:</label><br>
			<input type="text" name="username" id="user" value="'.$cleanInput['username'].'"/>
			<br><br>
			<label for="password">Password:</label><br>
			<input type="password" name="password" id="pword"/>
			<br><br>
			<input type="submit"
			name="loginsubmit"
			value="Log in" />
			<br><br>
			</form>
			<a href="registerform.php?'. SID .'">Click here to register</a>';
		}
		//If everything went well the user state is updated to logged in and user is redirected to the home page.
		if ($form_submitted === true && $user_match === true) {
			session_regenerate_id(true);
			$_SESSION['login_state'] = true;
			$_SESSION['username'] = $cleanInput['username'];
			ob_end_clean();
			header('Location: index.php?'. SID);
			exit;
		}
		ob_end_flush();
		?>
		<hr>
		<footer id="pagefooter">
			<p> Copyright &copy; 2016</p>
		</footer>
		<hr>
	</body>
</html>