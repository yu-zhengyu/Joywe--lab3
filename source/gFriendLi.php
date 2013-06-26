<?php
session_start();
include_once("control/control.php");
include_once("control/datetime.php");
$user = getDataById(new ReflectionClass('User'),'user',$_SESSION['userID']);
$friends = $user->getFriends();
$friNum = ($user->getFriendNum() > 4) ? 4:$user->getFriendNum();
$flag = 0;
$suitFri;
$year1 = 2012;
$month1 = 1;
$day1 = 1;
$start = -1;
$year2 = 2100;
$month2 = 12;
$day2 = 31;
$end = 24;

?>
<!DOCTYPE html>
    <html>
    <head>
        
        <link rel="stylesheet" type="text/css" href="makeactivity.php">
        <script src="js/bootstrap.min.js"></script>
        <script src="js/homepage.js"></script>
        <title> 添加好友 </title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body>
<?php
if(isset($_REQUEST['y1'])) {
    $year1 = $_REQUEST['y1'];
    $flag = 1;
}
if(isset($_REQUEST['m1'])) {
    $month1 = $_REQUEST['m1'];
    $flag = 1;
}
if(isset($_REQUEST['d1'])) {
    $day1 = $_REQUEST['d1'];
    $flag = 1;
}
if(isset($_REQUEST['s1'])) {
    $start = $_REQUEST['s1'];
    $flag = 1;
}
if(isset($_REQUEST['y2'])) {
    $year2 = $_REQUEST['y2'];
    $flag = 1;
}
if(isset($_REQUEST['m2'])) {
    $month2 = $_REQUEST['m2'];
    $flag = 1;
}
if(isset($_REQUEST['d2'])) {
    $day2 = $_REQUEST['d2'];
    $flag = 1;
}
if(isset($_REQUEST['s2'])) {
    $end = $_REQUEST['s2'];
    $flag = 1;
}
$suitFri = array();
$chooseDate1 = new DateT($year1,$month1,$day1,$start);
$chooseDate2 = new DateT($year2,$month2,$day2,$end);
foreach( $friends as  $fri ){
    $activity = $fri->getActivities();
    $tf = true;
    if( !empty($activity)) {
        foreach( $activity as $act) {
            $datetimeS = $act->actdateS;
            $datetimeE = $act->actdateE;
            $datestart = $act->actstart;
            $dateend = $act->actend;
            $dsA = explode("-",$datetimeS);
            $deA = explode("-",$datetimeE);
            if( ($chooseDate1->isLess($dsA[0],$dsA[1],$dsA[2],$datestart) && $chooseDate1->isMore($deA[0],$deA[1],$deA[2],$dateend) &&
                $chooseDate2->isLess($deA[0],$deA[1],$deA[2],$dateend)) ||($chooseDate1->isMore($dsA[0],$dsA[1],$dsA[2],$datestart) &&
                $chooseDate2->isLess($dsA[0],$dsA[1],$dsA[2],$datestart) && $chooseDate2->isLess($deA[0],$deA[1],$deA[2],$dateend))||
                ($chooseDate1->isMore($deA[0],$deA[1],$deA[2],$dateend) && $chooseDate2->isLess($dsA[0],$dsA[1],$dsA[2],$datestart) &&
                $chooseDate2->isMore($deA[0],$deA[1],$deA[2],$dateend))) {
                $tf = false;
                break;
            }
        }
    }
    if( $tf )
        array_push($suitFri,$fri->id);
}
$suitLength = count($suitFri);
if($user == null) {
    include_once 'login.php';
}
else {
    if( $flag == 0) {
?>
<!--     <dl>
        <dd>
            <img alt="userface" style="width: 60px; height: 60px;"src="images/<?php echo empty($user->picPath)?'user.jpg':$user->picPath?>">
            <a href="homepage.php?id=<?=$user->id?>"><?= $user->name?></a>
        </dd>
    </dl> -->
        <a href="homepage.php?id=<?=$user->id?>">
        <div class="friend_img">
            <img width="60px" height="60px" alt="userface" src="images/<?php echo empty($user->picPath)?'user.jpg':$user->picPath?>">   
        </div>
        <div class="friend_info">
            <div class="friend_name"><?= $user->name?></div>
            <div class="friend_detail"><?= $user->info?></div>
            </div>
        </a>


<?php
    for($i = 0; $i < $friNum; $i++) {
?>
<!--     <dl>
        <dd>
            <img alt="userface" style="width: 60px; height: 60px;"src="images/<?php echo empty($friends[$i]->picPath)?'user.jpg':$friends[$i]->picPath?>">
            <a href="homepage.php?id=<?=$friends[$i]->id?>"><?= $friends[$i]->name?></a>
        </dd>
    </dl> -->

    <a href="homepage.php?id=<?=$friends[$i]->id?>">
        <div class="friend_img">
            <img width="60px" height="60px" alt="userface" src="images/<?php echo empty($friends[$i]->picPath)?'user.jpg':$friends[$i]->picPath?>">   
        </div>
        <div class="friend_info">
            <div class="friend_name"><?= $friends[$i]->name?></div>
            <div class="friend_detail"><?= $friends[$i]->info?></div>
            </div>
    </a>

<?php } }
    else {
?>

    <div class="friend">
        <input class="friend_choice" type="checkbox" onchange="adduser();" name="friuser" value="<?=$user->name?>" id="<?=$user->id?>">
        <a href="homepage.php?id=<?=$user->id?>">
        <div class="friend_img">
            <img width="60px" height="60px" alt="userface" src="images/<?php echo empty($user->picPath)?'user.jpg':$user->picPath?>">   
        </div>
        <div class="friend_info">
            <div class="friend_name"><?= $user->name?></div>
            <div class="friend_detail"><?= $user->info?></div>
            </div>
        </a>
    </div>

    
    <?php
        for($i = 0; $i < $suitLength; $i++) {
            $fri = getDataById(new ReflectionClass('User'),'user',$suitFri[$i]);
            ?>
<!--     <dl>
         <dd>
             <img alt="userface" style="width: 60px; height: 60px;"src="images/<?php echo empty($fri->picPath)?'user.jpg':$fri->picPath?>">
             <a href="homepage.php?id=<?=$fri->id?>"><?= $fri->name?></a>
             <input type="checkbox" onchange="adduser();" name="friuser" value="<?=$fri->name?>" id="<?=$fri->id?>" >
         </dd>
    </dl> -->

    <div class="friend">
        <input class="friend_choice" type="checkbox" onchange="adduser();" name="friuser" value="<?=$fri->name?>" id="<?=$fri->id?>" >
    <a href="homepage.php?id=<?=$friends[$i]->id?>">
        <div class="friend_img">
            <img width="60px" height="60px" alt="userface" src="images/<?php echo empty($friends[$i]->picPath)?'user.jpg':$friends[$i]->picPath?>">   
        </div>
        <div class="friend_info">
            <div class="friend_name"><?= $friends[$i]->name?></div>
            <div class="friend_detail"><?= $friends[$i]->info?></div>
        </div>
        
    </a>
    </div>
    
</body>
</html>
<?php }
    }
} ?>