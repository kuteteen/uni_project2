<?php
//Main navigation options
echo '<div>
		<b>&nbsp;
		<a href="index.php?'. SID .'">Home</a> <span> |</span> 
		<a href="about.php?'. SID .'">About Us</a><span> |</span>
		<a href="myaccount.php?'. SID .'">My account</a>
		</b>
	</div>';
//Checks if user is logged in. If that's true, the option to log out from current account is displayed.
if (isset($_SESSION['login_state']) && $_SESSION['login_state'] === true){
	echo '<hr><div align="right">
		<p>You are currently logged in as:<b> '.$_SESSION['username'].
		'</p></b>
		<form action="includes/logout.php?'. SID .'" method="post">
		<input type="submit"
		name="logoutsubmit"
		value="Log out" />
		</form>
		</div>
		';
} else {
	//Secondary navigation for log in and register options.
	echo '<div align="right">
		<b><a href="loginform.php?'. SID .'">Log in</a><span> |</span>
		<a href="registerform.php?'. SID .'">Register</a>&nbsp;</b>
		</div>';
}
?>