<!DOCTYPE html>
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="css/result.css" type="text/css" rel="stylesheet" />
	<title> 注册失败页面 </title>
	</head>
	<body>
	<div id="overall">
	<?php 
	include_once 'control/control.php'; 
	if( !empty($_REQUEST['user_name']) && isset($_REQUEST['user_name'])){
		$userName = $_REQUEST['user_name'];
		$tf = searchUser($userName);
		if( $tf == false) {
			$passWord = $_REQUEST['password'];
	        $passWord2 = $_REQUEST['password2'];
	        $email = $_REQUEST['email'];
	        if(!empty($_REQUEST['password']) && !empty($_REQUEST['password2']) && $passWord == $passWord2) {
			    $return = addUser($userName,$passWord,$email);
	        }
	        else {
	            $retrun = "error";
	        }
	    }
	    else {
	    	$return ="error";
	    }
	}
	else
		$return ="error";
	if($return == "error 1" || $return == "error") {
	?>
	<div id ="failed" class="failed">
	<a href="register.php">
		<img width="600" height="600" src="images/register_fail.png"><a href="register.php">
	</a>
	<script type="text/javascript" language="javascript">
		setTimeout("window.location.href='register.php'",5000);
	</script>
	</div>
	<?php }else{ ?>
	<div id = "success">
	<script type="text/javascript" language="javascript">
		window.location.href="login.php";
	</script>
	</div>
	<?php
		}
	?>
	</div>
	</body>
	</html>