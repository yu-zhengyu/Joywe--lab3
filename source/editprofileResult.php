
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="css/result.css" type="text/css" rel="stylesheet" />
    <title> 修改成功/失败页面 </title>
</head>
<body>
<div id="overall">
    <?php
    include_once 'control/control.php';
    $user = getDataById(new ReflectionClass('User'),'user',$_REQUEST['id']);
    $choose = array(0,0,0,0,0,0,0,0,0,0,0);
    if( isset($_REQUEST['submit'])){
        $methods = $_REQUEST['method'];
        if($methods == "information") {
            if( isset($_FILES["picPath"]) )
            {
                if (( ($_FILES["picPath"]["type"] == "image/gif") ||
                    ($_FILES["picPath"]["type"] == "image/jpeg") ||
                    ($_FILES["picPath"]["type"] == "image/jpg") ||
                    ($_FILES["picPath"]["type"] == "image/png") ||
                    ($_FILES["picPath"]["type"] == "image/pjpeg")
                )&& ($_FILES["picPath"]["size"] < 200000) )
                {
                    if( $_FILES["picPath"]["error"] == 0 ){
                        $fileName = $_FILES['picPath']['name'];//得到上传文件的名字
                        $tempname = explode('.',$fileName);//将文件名以'.'分割得到后缀名,得到一个数组
                        $newname = strval($user->name) . "." . $tempname[1] ;
                        move_uploaded_file($_FILES["picPath"]["tmp_name"],"images/" . $newname);
                        modify("user",array("PicPath"=>$newname),$user->id);
                    }
                    else {
                        $choose[0] = 1;
                    }
                }
                else {
                    $choose[10] = 1;
                }
            }
            if(empty($_REQUEST['username'])) {
                $choose[1] = 1;
            }
            else {
                modify("user",array("UserName"=>$_REQUEST['username']),$user->id);
            }
            if(empty($_REQUEST['info'])){
                $choose[2] = 1;
            }
            else {
                modify("user",array("Info"=>$_REQUEST['info']),$user->id);
            }
            if(empty($_REQUEST['email'])){
                $choose[3] = 1;
            }
            else {
                modify("user",array("Email"=>$_REQUEST['email']),$user->id);
            }
            if(empty($_REQUEST['phone'])){
                $choose[4] = 1;
            }
            else {
                modify("user",array("Phone"=>$_REQUEST['phone']),$user->id);
            }
            if(empty($_REQUEST['birth'])){
                $choose[5] = 1;
            }
            else {
                modify("user",array("Birth"=>$_REQUEST['birth']),$user->id);
            }
            if(empty($_REQUEST['city'])){
                $choose[6] = 1;
            }
            else {
                modify("user",array("City"=>$_REQUEST['city']),$user->id);
            }
            if(empty($_REQUEST['sex'])) {
                $choose[7] = 1;
            }
            else {
                modify("user",array("Sex"=>$_REQUEST['sex']),$user->id);
            }
        }
        else {
            if(isset($_REQUEST['oriPass']) && isset($_REQUEST['newPass']) && isset($_REQUEST['conPass']) ) {
                $oripass = $_REQUEST['oriPass'];
                $newpass = $_REQUEST['newPass'];
                $conpass = $_REQUEST['conPass'];
                $pwmd = md5(md5($oripass));
                if( $pwmd != $user->password )
                    $choose[8] = 1;
                else if($newpass != $conpass)
                    $choose[9] = 1;
                if( $pwmd == $user->password && $newpass == $conpass) {
                    modifyPassword($user->id,$newpass);
                }
            }
        }
    }
    if($choose[0] == 1) {
        ?>
        <div id ="failed">
            <p>头像添加失败，服务器没有响应 ，<a href="editprofile.php?id=<?= $user->id?>&method=<?=$methods?>">返回修改</a></p>
        </div>
    <?php }
    else if($choose[10] == 1) {
        ?>
        <div id ="failed">
            <p>用户头像修改失败，请只上传图片格式的文件，且图片大小不要超过200KB。，<a href="editprofile.php?id=<?= $user->id?>&method=<?=$methods?>">返回修改</a></p>
        </div>
    <?php }
    else if($choose[1] == 1) {
        ?>
        <div id ="failed">
            <p>用户名修改失败，请检查信息 ，<a href="editprofile.php?id=<?= $user->id?>&method=<?=$methods?>">返回修改</a></p>
        </div>
    <?php }
    else if($choose[2] == 1) {
        ?>
        <div id ="failed">
            <p>个人简介修改失败，请检查信息 ，<a href="editprofile.php?id=<?= $user->id?>&method=<?=$methods?>">返回修改</a></p>
        </div>
    <?php }
    else if($choose[3] == 1) {
        ?>
        <div id ="failed">
            <p>邮箱修改失败，请检查信息 ，<a href="editprofile.php?id=<?= $user->id?>&method=<?=$methods?>">返回修改</a></p>
        </div>
    <?php }
    else if($choose[4] == 1) {
        ?>
        <div id ="failed">
            <p>手机修改失败，请检查信息 ，<a href="editprofile.php?id=<?= $user->id?>&method=<?=$methods?>">返回修改</a></p>
        </div>
    <?php }
    else if($choose[5] == 1) {
        ?>
        <div id ="failed">
            <p>生日修改失败，请检查信息 ，<a href="editprofile.php?id=<?= $user->id?>&method=<?=$methods?>">返回修改</a></p>
        </div>
    <?php }
    else if($choose[6] == 1) {
        ?>
        <div id ="failed">
            <p>城市修改失败，请检查信息 ，<a href="editprofile.php?id=<?= $user->id?>&method=<?=$methods?>">返回修改</a></p>
        </div>
    <?php }
    else if($choose[7] == 1) {
        ?>
        <div id ="failed">
            <p>性别修改失败，请检查信息 ，<a href="editprofile.php?id=<?= $user->id?>&method=<?=$methods?>">返回修改</a></p>
        </div>
    <?php }
    else if($choose[8] == 1) {
        ?>
        <div id ="failed">
            <p>原密码输入错误，请检查信息 ，<a href="editprofile.php?id=<?= $user->id?>&method=<?=$methods?>">返回修改</a></p>
        </div>
    <?php }
    else if($choose[9] == 1) {
        ?>
        <div id ="failed">
            <p>新密码确认失败，请检查信息 ，<a href="editprofile.php?id=<?= $user->id?>&method=<?=$methods?>">返回修改</a></p>
        </div>
    <?php }
    else{
        ?>
        <div id = "success" class="success">
            <a href="homepage.php">
            <img width="600" height="600" src="images/profile_sucess.png">
            </a>
            <script type="text/javascript">
                 setTimeout("window.location.href='homepage.php'",5000);
            </script>
        </div>
    <?php
    }
    ?>
</div>
</body>
</html>