<!DOCTYPE html>
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="css/bootstrap.min.css" type="text/css" rel="stylesheet" />
	<link href="css/bootstrap-responsive.min.css" type="text/css" rel="stylesheet" />
	<link href="css/login.css" type="text/css" rel="stylesheet" />
	<link href="images/icon.png" rel="shortcut icon">
	<title> 登录页面 </title>
	</head>
	<body>
	<div id = "wrapper">
		<div id="header"></div>
		<div id="content">
			<img class="header_img" src="images/header.png"/>
				<div class="clearfix">
					<div class="article">
					<form action="loginResult.php" method="post" name="form1">

						<div class="login">

						<div class="item">
							<input id ="login_name" class="new-input" type="text" placeholder="User name" tabindex="1" maxlength="15" name="username">
						</div>
						<a class="register" href = "register.php">Join us</a>
						<div class="item">
							<input id="password" class="new-input" type="password" placeholder="Password" maxlength="20" tabindex="2" name="password">
						</div>
						</div>
							
						<div class="item-submit">
                            <input type="image" id="button" name="login" title="login" src="images/joywe2.png" onClick="document.formName.submit()"> 
						</div>
					</form>
				</div>
					<div class="aside">
				</div>
				</div>
		</div>
	</div>
		<?php include("footer.php");?>			
	</body>
</html>
