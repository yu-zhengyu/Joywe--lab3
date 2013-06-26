<?php
	session_start();
	$_SESSION['userID'] = null;
	header("Location:../login.php");
?>