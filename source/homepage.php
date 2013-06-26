<?php
session_start();
include_once("control/control.php");
$user = getDataById(new ReflectionClass('User'),'user',$_SESSION['userID']);
if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    $user = getDataById(new ReflectionClass('User'),'user',$id);
}
$user2 = getDataById(new ReflectionClass('User'),'user',$_SESSION['userID']);
if($user == null) {
    include_once 'login.php';
}
else {
    $friends = $user->getFriends();
    $friNum = $user->getFriendNum();
    $activities = $user->getActivities();
    $actNum = $user->getActivityNum();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="css/bootstrap.min.css" rel="stylesheet" />
        <link href="css/index.css" rel="stylesheet" />
        <link href="images/icon.png" rel="shortcut icon">
        <script src="js/bootstrap.min.js"></script>
        <script src="js/homepage.js"></script>
        <title> Joywe班级聚会 </title>
    </head>
    <body>
        <div class="header_home">
            <div class="header_top">
                <a href="control/logout.php"><img style="width:24px; height:24px;" title="退出" src="images/logout.png"></a>
                <a href="#">
                    <div onmouseover="showMemu2(this);" onmouseout="hideMenu2(this)">
                        <div  id="show2" class="menulist2 menulist_set2">
                            <ul class="gn_text_list2">
                                <li><a href="editprofile.php?id=<?=$user2->id?>&method=information" >帐号设置</a></li>
                                <li><a href="editprofile.php?id=<?=$user2->id?>&method=password" >密码修改</a></li>
                            </ul>
                        </div>
                        <img style="width:24px; height:24px;" title="个人设置" src="images/profile_setting.png">
                    </div>
                </a>
                <a href="makeactivity.php?id=<?=$user2->id?>"><img class="setimg2" style="width:24px; height:24px;" title="添加活动" src="images/add_activity.png"></a>
                <div class="header_top_name"><a href="homepage.php?id=<?= $user2->id?>"><?= $user2->name?></a></div>
              <!--  <a href="homepage.php?id=<?=$user2->id?>"><img style="width:24px; height:24px;" title="回到我的主页" src="images/add_activity.png"></a> -->

            </div>

            <div class="header_content">
                <div class="span3">
                    <a href="homepage.php?id=<?= $user->id?>"><img id="user_img" alt="userface" src="images/<?php echo empty($user->picPath)?'user.jpg':$user->picPath?>"/></a>
                </div>
                <div class="span5">
                    <div class="name"><?= $user->name?></div>
                    <div class="info"><?= $user->info?></div>
                    <?php if( $user->id == $user2->id ) { ?>
                        <a href="makeactivity.php?id=<?=$user->id?>"><img src="images/add.png" /></a>
                        <div class="menulist menulist_set" onmouseover="showMemu(this);" onmouseout="hideMenu(this)" id="setimg">
                            <a><img class="setimg2" src="images/set.png" /></a>
                            <div  id="show">
                            <ul class="gn_text_list">
                                <li><a href="editprofile.php?id=<?=$user->id?>&method=information" >帐号设置</a></li>
                                <li><a href="editprofile.php?id=<?=$user->id?>&method=password" >密码修改</a></li>
                            </ul>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="span3">
                    <a href="homepage.php?id=<?= $user2->id?>"><img title="Back to my homepage" class="joywe" src="images/joywe.png"/></a>
                    <table>
                    <tr><td class="actAndFriNum"><?= $actNum?></td><td class="actAndFriNum"><?= $friNum?></td></tr>
                    <tr><td class="actAndFri">ACTIVITIES</td><td class="actAndFri">FRIENDS</td></tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="content">
            <article>
                <?php if(isset($_REQUEST['add']) && $_REQUEST['add'] == "add") {
                    $userA = $_REQUEST['userIDA'];
                    $userB = $_REQUEST['userIDB'];
                    addfriend($userA,$userB);
                }
                if( isset($_REQUEST['delete']) && $_REQUEST['delete'] == "delete") {
                    $userA = $_REQUEST['userAid'];
                    $userB = $_REQUEST['userBid'];
                    deleteFri($userA,$userB);
                }
                if(isset($_REQUEST['deleteAct']) && $_REQUEST['deleteAct'] == "deleteAct") {
                    $DActID = $_REQUEST['Actid'];
                    deleteAct($DActID);
                }
                if( isset($_REQUEST['search']) && $_REQUEST['search'] == "search") { ?>
                    <section>
                        <div class="search_content">
                            <div class="search_banner">
                                <p>Search Result</p>
                            </div>
                        <?php
                        $sub = $_REQUEST['submit'];
                        $target = $_REQUEST['target'];
                        $searchF = searchUser($target);
                        if(isset($sub)) {
                            if( $searchF != false ) {
                                ?>
                                <!-- <dl>
                                    <dd>
                                        <img alt="userface" style="width: 100px; height: 100px;" src="images/<?php echo empty($searchF->picPath)?'user.jpg':$searchF->picPath?>">
                                        <a href="homepage.php?id=<?=$searchF->id?>"}><?=$searchF->name?></a>
                                    </dd>
                                </dl> -->
                                <div class="searchinfo_content">
                                <a href="homepage.php?id=<?=$searchF->id?>">
                                    <div class="search_img">
                                    <img width="120px" height="120px" alt="userface" src="images/<?php echo empty($searchF->picPath)?'user.jpg':$searchF->picPath?>">   
                                    </div>
                                    <div class="search_info">
                                        <div class="search_name"><?= $searchF->name?></div>
                                        <div class="search_detail"><?= $searchF->info?></div>
                                    </div>
                                </a>
                                </div>

                            <?php
                            } else {
                                ?>
                                <!-- <h3>查无此人！</h3> -->
                                <img class="search_fail" src="images/search_fail2.png"/>
                            <?php }
                        } ?>
                    </div>
                    </section>
                <?php } else {
                    if( $user->id == $user2->id ) {
                    if( $actNum == 0 ) {
                 ?>
                    <!-- <h3>`(*∩_∩*)′你还没有创建活动哦！</h3> -->
                    <div class="activity_content_without_banner">
                    <a href="makeactivity.php?id=<?=$user->id?>"><img width="500" height="500" src="images/make_activity.png"></a>
                    </div>
                <?php
                    } else {
                        if(isset($_REQUEST['detail']) && $_REQUEST['detail'] == "detail") {
                            $actid = $_REQUEST['actid'];
                            $actContent = getDataById(new ReflectionClass('Activity'),'activity',$actid);
                            $actPeo = $actContent->getUsers(0);
                            $actuser = getDataById(new ReflectionClass('User'),'user',$actContent->actuserID);
                ?>
                 <section>
                    <div class="activity_content">
                        <div class="activity_banner">
                            <p>Activity's Information</p>
                        </div>

                     <table class="activity_table">
                         <tr><td class="activity_tag" id="wid">活动名称</td><td class="activity_content"><?=$actContent->actname?></td></tr>
                         <tr><td class="activity_tag" id="wid">活动时间</td><td class="activity_content"><?=$actContent->actdateS?> <?=$actContent->actstart?>:00 To
                             <?=$actContent->actdateE?> <?=$actContent->actend?>:00</td></tr>
                         <tr><td class="activity_tag" id="wid">活动地点</td><td class="activity_content"><?=$actContent->actloc?></td></tr>
                         <tr><td class="activity_tag" id="wid">活动信息</td><td class="activity_content"><?=$actContent->actinfo?></td></tr>
                         <tr><td class="activity_tag" id="wid">活动发起人</td><td class="activity_content"><?=$actuser->name?></td></tr>
                         <tr><td class="activity_tag" id="wid">活动参与者</td>
                             <td class="activity_content">
                             <?php foreach($actPeo as $row) { ?>
                             <a href="homepage.php?id=<?=$row->id?>"><?=$row->name?></a>
                             <?php } ?>
                             </td>
                         </tr>
                     </table>

                    <?php if($user2->id == $actuser->id) { ?>
                         <form method="post" action="homepage.php?id=<?=$user2->id?>&deleteAct=deleteAct" name="form5">
                             <input style="display: none" name="Actid" value="<?=$actid?>">
                             <div class="btn-button">
                             <a onclick="return confirm('确定要删除活动?')"><button class="btn btn-left"type="submit">删除活动</button></a>
                            </div>
                         </form>

                     <?php } ?>
                 </div>
                 </section>
                <?php    } else { ?>
                <section>
                    <?php
                        foreach($activities as $act) {
                    ?>
                        <div class="activity">
                        <div class="activity_left">
                            <div class="actname"><?= $act->actname?></div>
                            <div class="from_text">来自</div>
                            <div class="user_name"><a href="homepage.php?id=<?= $act->getUser()->id?>"><?= $act->getUser()->name?></a></div>
                        </div>
                        <div class="activity_right">
                            <div class="actinfo">
                                <?= $act->actinfo?>&nbsp;
                            </div>
                            <div class="actloc">
                            <?= $act->actloc?>
                            </div>
                            <div class="actdate">
                            <?= $act->actdateS ?>&nbsp;<?= $act->actstart?>:00 to <?= $act->actdateE ?>&nbsp;<?= $act->actend?>:00
                            </div>
                            <div class="detail">
                            <form name="form4" action="homepage.php?id=<?=$user2->id?>&detail=detail">
                                    <input style="display: none;" name="actid" value="<?=$act->id?>">
                                    <button class="btn btn-info" setype="submit" name="detail" value="detail">详情</button>
                            </form>
                            </div>
                        </div>
                    </div>
                    <?php } ?>    
                    
                </section>
            <?php } } }  else { ?>
                <section>
                    <div class="user_content">
                        <div class="user_banner">
                            <p>User's Information</p>
                        </div>

                    <table class="user_table">
                        <tr><td class="user_tag">用户名：</td><td class="userinfo_content"><?= $user->name?></td></tr>
                        <tr><td class="user_tag">性别：</td><td class="userinfo_content"><?= $user->sex == 'M'?'男':'女' ?></td></tr>
                        <tr><td class="user_tag">邮箱：</td><td class="userinfo_content"><?=$user->email?></td></tr>
                        <tr><td class="user_tag">手机：</td><td class="userinfo_content"><?=$user->phone?></td></tr>
                        <tr><td class="user_tag">出生年月：</td><td class="userinfo_content"><?= $user->birth?></td></tr>
                        <tr><td class="user_tag">居住城市：</td><td class="userinfo_content"><?= $user->city?></td></tr>
                        <tr><td class="user_tag">个性签名：</td><td class="userinfo_content"><?= $user->info?></td></tr>
                    </table>

                    <?php if( $user2->isFriend($user->id)) {?>
                        <form method="post" action="homepage.php?id=<?=$user2->id?>&delete=delete" name="form3">
                            <input style="display: none" name="userAid" value="<?=$user2->id?>">
                            <input style="display: none" name="userBid" value="<?=$user->id?>">
                            <div class="btn-button">
                            <a onclick="alert('删除好友成功！')"><input class="btn" type="submit" value="删除好友"></a>
                            </div>
                        </form>
                    <?php } else { ?>
                        <form method="post" action="homepage.php?id=<?=$user2->id?>&add=add" name="form2">
                            <input style="display: none" name="userIDA" value="<?=$user2->id?>">
                            <input style="display: none" name="userIDB" value="<?=$user->id?>">
                            <div class="btn-button">
                            <a onclick="alert('添加好友成功！')"><input class="btn" type="submit" value="加为好友"></a>
                            </div>
                        </form>
                    <?php }?>
                </div>
                </section>
            <?php } }?>
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