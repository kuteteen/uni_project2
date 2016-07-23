<?php
session_start();
//When the Log out button is pressed, destroy session and redirect to homepage.
	if (isset($_POST['logoutsubmit'])) {
		session_destroy();
		header('Location: ../index.php?logout_success=true');
		exit;
	}
?>