<?php
//Use of sessions to maintain state.
session_start();
//Prevent output until certain that user hasn't registered successfully (allows header change).
ob_start();
?>
<!DOCTYPE html>
<html>
    <head>
		<title>Register</title>
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
		$errors_found = false;

		$cleanInput = array();
		$required = array('firstname','lastname','emailaddress','username','password','repassword');
		$errors = array();

		//Executes if form has been submitted.
		if (isset($_POST['detailsubmit'])) {
			$form_submitted = true;
			//Cleaning user input and adding it to a separate array.
			foreach ($_POST as $key => $value){
			$cleanInput[$key] = htmlentities(trim($value));
			}
			//Main loop that checks all required fields one by one.
			$counter = 0;
			while (count($required) > $counter) {
				//Temporary variable to reduce typing.
				$inputValue = $cleanInput[$required[$counter]];
				//If the required field is present in the input array, and isn't empty, execute the block.
				if (isset($inputValue) && !empty($inputValue)) {
					//Validating each input using a switch statement.
					switch ($required[$counter]) {
						case 'firstname':
							if (strlen($inputValue) <= 50 && ctype_alpha($inputValue)) {
								$inputValue = ucfirst($inputValue);
								$valid_firstname = $inputValue;
							} elseif (strlen($inputValue) > 50) {
								$errors_found = true;
								$errors[] = 'First name is longer than 50 characters.';
							} else {
								$errors_found = true;
								$errors[] = 'First name contains symbols other than letters';
							}	
							break;
						case 'lastname':
							if (strlen($inputValue) <= 50 && ctype_alpha($inputValue)) {
								$inputValue = ucfirst($inputValue);
								$valid_lastname = $inputValue;
							} elseif (strlen($inputValue) > 50) {
								$errors_found = true;
								$errors[] = 'Last name is longer than 50 characters.';
							} else {
								$errors_found = true;
								$errors[] = 'Last name contains symbols other than letters';
							}	
							break;
						case 'emailaddress':
							if (filter_var($inputValue, FILTER_VALIDATE_EMAIL)) {
								$valid_email = $inputValue;
							} else {
								$errors_found = true;
								$errors[] = 'E-mail address is invalid.';
							}
							break;
						case 'username': 
							//Loop that checks if the username entered already exists in the user data file.
							$handle = fopen('data/userdata.txt', 'r');
							rewind($handle);
							$duplicate = false;
							while (!feof($handle)) {
								$parsedLine = explode(":",fgets($handle));
								if (count($parsedLine) > 1 && $parsedLine[1] === $inputValue) {
									$duplicate = true;
									$errors_found = true;
									$errors[] = 'This username already exists.';
									break;
								}
							}
							fclose($handle);						
							if (strlen($inputValue) <= 20 && ctype_alnum($inputValue) && $duplicate === false) {
								$valid_username = $inputValue;
							} elseif (strlen($inputValue) > 20) {
								$errors_found = true;
								$errors[] = 'Username is longer than 20 characters.';
							} elseif (!ctype_alnum($inputValue)) {
								$errors_found = true;
								$errors[] = 'Username contains symbols other than letters and numbers.';	
							}
							unset($duplicate);
							break;
						case 'password': 
							if (6 <= strlen($inputValue) && strlen($inputValue) <= 20) {
								$first_password = $inputValue;
							} elseif (strlen($inputValue) < 6) {
								$errors_found = true;
								$errors[] = 'Password is shorter than 6 characters.';	
							} else {
								$errors_found = true;
								$errors[] = 'Password is longer than 20 characters.';
							}
							break;
						case 'repassword':
							//If the first password wasn't entered, it is set to an empty string.
							if (!isset($first_password)) {
								$first_password = "";
							} 
							//This condition also check if the re-entered password matches the first password.
							if (6 <= strlen($inputValue) && strlen($inputValue) <= 20 && $inputValue === $first_password) {
								$valid_password = $inputValue;
							} else {
								$errors_found = true;
								$errors[] = "Re-entered password doesn't match.";	
							} 
							break;
						default:
							//This should never execute but in case it does, it is set to be an unexpected error.
							$errors_found = true;
							$errors[] = "Unexpected error";
							break;
					}
				//Error messages for empty fields.
				} else {
					$errors_found = true;
					$fields = array("First Name","Last Name","E-mail","Username","Password","Re-enter password");
					$errors[] = $fields[$counter]." is required.";
				}
				++$counter;
			}
			unset($inputValue,$counter,$fields);
		}
		//Main form is displayed when nothing is submitted.
		if 	($form_submitted === false) {
			echo '<h1>Register</h1>
			<p><b>Please enter your details:
			<br>(All fileds are required)</b></p>
			<form action="registerform.php?'. SID .'" method="post">
			<label for="fname">First Name:</label><br>
			<input type="text" name="firstname" id="fname" />
			<br><br>
			<label for="lname">Last Name:</label><br>
			<input type="text" name="lastname" id="lname" />
			<br><br>
			<label for="email">E-mail:</label><br>
			<input type="email" name="emailaddress" id="email" />
			<br><br>
			<label for="uname">Username:</label><br>
			<input type="text" name="username" id="uname" />
			<br><br>
			<label for="pword">Password (8-20 characters):</label><br>
			<input type="password" name="password" id="pword"/>
			<br><br>
			<label for="rpword">Re-enter Password:</label><br>
			<input type="password" name="repassword" id="rpword"/>
			<br><br>
			<input type="hidden" name="date" value="'.date("d-m-Y").'" />
			<input type="submit"
			name="detailsubmit"
			value="Submit" />
			<br><br>
			</form>';
		}
		//If errors are found, the form is re-displayed together with valid input and error messages.
		if 	($errors_found === true) {
			echo '<h1>Register</h1>
			<p><b>Please enter your details:
			<br>(All fileds are required)</b></p>';
			echo "<p><b>There were some errors:</p></b>";
			$count = 0;
			while (count($errors) > $count) {
				echo '* '.$errors[$count].'<br><br>';
				++$count;
			}
			unset($count);
			echo '<form action="registerform.php?'. SID .'" method="post">
			<label for="fname">First Name:</label><br>
			<input type="text" name="firstname" id="fname" value="'.$cleanInput['firstname'].'" />
			<br><br>
			<label for="lname">Last Name:</label><br>
			<input type="text" name="lastname" id="lname" value="'.$cleanInput['lastname'].'"/>
			<br><br>
			<label for="email">E-mail:</label><br>
			<input type="email" name="emailaddress" id="email" value="'.$cleanInput['emailaddress'].'"/>
			<br><br>
			<label for="uname">Username:</label><br>
			<input type="text" name="username" id="uname" value="'.$cleanInput['username'].'"/>
			<br><br>
			<label for="pword">Password (8-20 characters):</label><br>
			<input type="password" name="password" id="pword" value="'.$cleanInput['password'].'"/>
			<br><br>
			<label for="rpword">Re-enter Password:</label><br>
			<input type="password" name="repassword" id="rpword" value="'.$cleanInput['repassword'].'"/>
			<br><br>
			<input type="hidden" name="date" value="'.date("d-m-Y").'" />
			<input type="submit"
			name="detailsubmit"
			value="Submit" />
			<br><br>
			</form>';	
		}
		//If everything went well, user data is saved and the user is redirected to a thank you message on the home page.
		if ($form_submitted === true && $errors_found === false) {
			$handle = fopen('data/userdata.txt', 'a');
			$data = 'Username:'.$valid_username.':Password:'.$valid_password.':Created:'.$cleanInput['date'].':Email:'.$valid_email.':Name:'.$valid_firstname.':Surname:'.$valid_lastname.PHP_EOL;
			fwrite($handle,$data);
			$_SESSION['registration_success'] = true;
			fclose($handle);
			unset($data,$valid_email,$valid_firstname,$valid_lastname,$valid_password,$valid_username,$first_password);
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