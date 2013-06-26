<!DOCTYPE html>
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/result.css">
	<link href="images/icon.png" rel="shortcut icon">
	<title> 登陆失败页面 </title>
	</head>
	<body>
	<div id="overall">
	<?php 
	session_start();
	include_once 'control/control.php'; 
	if( isset($_REQUEST['username'])){
		$userName = $_REQUEST['username'];
		$passWord = $_REQUEST['password'];
		$return=login($userName,$passWord);
	}
	if($return) {
		$_SESSION['userID'] = $return->id;
	?>
	<div id = "success">

	<script type="text/javascript" language="javascript">
		window.location.href="homepage.php";
	</script>
	</div>
	<?php }else{ ?>
	<div id ="failed" class="failed">
	<a href="login.php">
	<img width="600" height="600" class="login_fail" src="images/loginFail.png">
	</a>
	<script type="text/javascript" language="javascript">
	 	setTimeout("window.location.href='login.php'",5000);
	</script>
	</div>
	<?php
		}
	?>
	</div>
	</body>
</html>