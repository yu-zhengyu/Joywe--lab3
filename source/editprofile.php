<?php
include_once 'control/control.php';
$user = getDataById(new ReflectionClass('User'),'user',$_REQUEST['id']);
if($user == null) {
    include_once 'login.php';
}
else {
    $friends = $user->getFriends();
    $friNum = $user->getFriendNum();
    $actNum = $user->getActivityNum();
?>
<!DOCTYPE html>
    <html>
    <head>
        <link href="css/bootstrap.min.css" rel="stylesheet" />
		<link href="css/index.css" rel="stylesheet" />
		<link href="css/profile.css" rel="stylesheet"/>
        <link href="images/icon.png" rel="shortcut icon">
        <script src="js/bootstrap.min.js"></script>
        <script src="js/homepage.js"></script>
        <title> 修改个人信息 </title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body>
    <div class="header_home">
        <div class="header_top">
            <a href="control/logout.php"><img style="width:24px; height:24px;" title="退出" src="images/logout.png"></a>
            <a href="#">
                <div onmouseover="showMemu2(this);" onmouseout="hideMenu2(this)">
                    <div  id="show2" class="menulist2 menulist_set2">
                        <ul class="gn_text_list2">
                            <li><a href="editprofile.php?id=<?=$user->id?>&method=information" >帐号设置</a></li>
                            <li><a href="editprofile.php?id=<?=$user->id?>&method=password" >密码修改</a></li>
                        </ul>
                    </div>
                    <img style="width:24px; height:24px;" title="个人设置" src="images/profile_setting.png">
                </div>
            </a>
            <a href="makeactivity.php?id=<?=$user->id?>"><img class="setimg2" style="width:24px; height:24px;" title="添加活动" src="images/add_activity.png"></a>
            <div class="header_top_name"><a href="homepage.php?id=<?= $user->id?>"><?= $user->name?></a></div>
        </div>

        <div class="header_content">
            <div class="span3">
                <a href="homepage.php?id=<?= $user->id?>"><img id="user_img" alt="userface" src="images/<?php echo empty($user->picPath)?'user.jpg':$user->picPath?>"/></a>
            </div>
            <div class="span5">
                <div class="name"><?= $user->name?></div>
                <div class="info"><?= $user->info?></div>
                <a href="makeactivity.php?id=<?=$user->id?>"><img src="images/add.png" /></a>
                <div class="menulist menulist_set" onmouseover="showMemu(this);" onmouseout="hideMenu(this)" id="setimg">
                    <a><img class="setimg2" src="images/set.png" /></a>
                    <div  id="show" >
                    <ul class="gn_text_list">
                            <li><a href="editprofile.php?id=<?=$user->id?>&method=information" >帐号设置</a></li>
                            <li><a href="editprofile.php?id=<?=$user->id?>&method=password" >密码修改</a></li>
                    </ul>
                        </div>
                </div>
            </div>
            <div class="span3">
                <a href="homepage.php?id=<?= $user->id?>"><img title="Back to my homepage" class="joywe" src="images/joywe.png"/></a>
                <table>
                    <tr><td class="actAndFriNum"><?= $actNum?></td><td class="actAndFriNum"><?= $friNum?></td></tr>
                    <tr><td class="actAndFri">ACTIVITIES</td><td class="actAndFri">FRIENDS</td></tr>
                </table>
            </div>
        </div>
    </div>
    <?php $methods = $_REQUEST['method'] ?>
    <div class="content">
        <article>

            <?php if($methods == "information") { ?>
            <section>
				<div class="profile_content">
                    <div class="profile_banner">
                        <p>Profile setting</p>
                    </div>
                <form method="post" action="editprofileResult.php?id=<?= $user->id?>" name="form2">
                        <table class="profile_table">
                        <tr><td class="editTag">更改头像:</td>
                            <td class="editContent"><input type="file" name="picPath" value="<?= $user->picPath?>"></td></tr>
                        <tr><td class="editTag">性别：</td>
                            <td class="editContent">
                                <?php if($user->sex == "M") { ?>
                                    男 <input type="radio" name="sex" value="M" checked="checked"/>
                                    女 <input type="radio" name="sex" value="F" />
                                <?php } else { ?>
                                    男 <input type="radio" name="sex" value="M"/>
                                    女 <input type="radio" name="sex" value="F" checked="checked" />
                                <?php } ?>
                            </td>
                        </tr>
                        <tr><td class="editTag">生日：</td><td class="editContent"><input type="text" name="birth" value="<?= $user->birth?>"/></td></tr>
                        <tr><td class="editTag">个性签名：</td><td class="editContent"><input type="text" name="info" value="<?= $user->info?>"/></td></tr>
                        <tr><td class="editTag">用户名：</td><td class="editContent"><input type="text" name="username" value="<?= $user->name?>"/></td></tr>
                        
                        <tr><td class="editTag">邮箱：</td><td class="editContent"><input type="text" name="email" value="<?=$user->email?>"/></td></tr>
                        <tr><td class="editTag">手机：</td><td class="editContent"><input type="text" name="phone" value="<?=$user->phone?>"/></td></tr>
                        
                        <tr><td class="editTag">城市：</td><td class="editContent"><input type="text" name="city" value="<?= $user->city?>"/></td></tr>

                        
                    </table>
					<div class="profile_button">
                            <input class="btn btn-primary" type="submit" value="确认" name="submit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="homepage.php?id=<?=$user->id?>"><input  class="btn btn-primary" type="button" value="取消" /></a>
                            <input style="display: none" name="method" value = "information"/>
                      </div>
                </form>
            </section>
        <?php } else { ?>
            <section>
                <div class="password_content">
                    <div class="password_banner">
                        <p>Password Edit</p>
                    </div>
                <form method="post" action="editprofileResult.php?id=<?= $user->id?>" name="form3">
                    <table class="password_table">
                        <tr><td class="password_tag">原密码：</td><td class="passwordinfo_content"><input type="password" name="oriPass"/></td></tr>
                        <tr><td class="password_tag">新密码：</td><td class="passwordinfo_content"><input type="password" name="newPass"/></td></tr>
                        <tr><td class="password_tag">确认新密码：</td><td class="passwordinfo_content"><input type="password" name="conPass"/></td></tr>

                        
                    </table>
                            <div class="password_button">
                            <input class="btn btn-primary"type="submit" value="确认" name="submit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="homepage.php?id=<?= $user->id?>"><input class="btn btn-primary" type="button" value="取消" /></a>
                        </div>
                        <input style="display: none" name="method" value = "passW"/>
                </form>
            </div>
            </section>
        <?php } ?>
        </article>
        <aside>
			<div class="friend_content">
                <div class="friend_banner">
                    <p>My Friends</p>
                </div>
                <div class="input-append">
                    <form method="post" action="homepage.php?search=search" name="form1">
                    <input class="search" name="target" id="appendedInputButton" type="text">
                    <button id="search"  name="submit" class="btn" type="submit">Search</button>
                    </form>
                </div>
            <?php
            $num = 0;
            if( $friNum > 5 ){
                $num = 5;
            }
            else {
                $num = $friNum;
            }
            for($i = 0; $i < $num; $i++) {
                ?>
                <a href="homepage.php?id=<?=$friends[$i]->id?>">
                <div class="friend_img">
                    <img width="60px" height="60px" alt="userface" src="images/<?php echo empty($friends[$i]->picPath)?'user.jpg':$friends[$i]->picPath?>">   
                </div>
                <div class="friend_info">
                    <div class="friend_name"><?= $friends[$i]->name?></div>
                    <div class="friend_detail"><?= $friends[$i]->info?></div>
                </div>
                </a>
            <?php } ?>
        </aside>
        <div class="clear">
        </div>
    </div>
        <?php include("footer.php");?>
    </body>
    </html>
<?php } ?>