<?php
include_once("user.php");
include_once("activity.php");

function connect($user, $password) {
	$db = new PDO('mysql:host=127.0.0.1;dbname=classparty;charset=UTF-8', 'root', '');
	$db->query("set names utf8");
	return $db;
}

$db = connect('root', '');

//成功返回user类，已存在帐号返回error，失败返回false
function addUser($userName,$password,$email) {
	global $db;
	try {
		$pwmd = md5(md5($password));
		$res = $db->query( "SELECT 1 from user where UserName = '$userName'" );
		$temp = $res->fetch();
		if(!empty($temp)){
			return "error 1";
		}
		
		$db->exec("INSERT INTO user VALUES(null,'$userName','$pwmd','$email','','','',null,'','','')");
		
		$id = getLastInsertId();

		$res = $db->query( "SELECT * from user order by id desc limit 1" );
		return new User($res->fetch());

	} catch (Exception $e) {
		$db->rollBack();
		return "error";
	}
}

//成功返回类，失败返回false
function login($userName,$password){
    global $db;
    try {
        $pwmd = md5(md5($password));
        $res = $db->query("select * from user where userName = '$userName'");
        $isfind = false;

        foreach($res as $row)
            if($row[2] == $pwmd){
                $isfind = true;
                break;
            }

        if ($isfind){
            $user = new user($row);
            return $user;
        }else{
            $user = null;
            return false;
        }

    } catch (Exception $e) {
        $db->rollBack();
        return false;
    }
}

//没有检验合法性的，一旦提交就修改
function modifyPassword($id,$newPassword){
	global $db;
	try {
		$pwmd = md5(md5($newPassword));
		modify('user',array("Password"=>$pwmd),$id);
	} catch (Exception $e) {
		$db->rollBack();
		return false;
	}
}

function deleteFri($id,$id2){
    global $db;
    try {
        $result = true;
        $db->exec("DELETE FROM friend WHERE UserA = $id and UserB = $id2");
        return $result;
    } catch (Exception $e) {
        $db->rollBack();
        return false;
    }
}
function deleteAct($actid){
    global $db;
    try {
        $result = true;
        $db->exec("DELETE FROM joinin WHERE ActID = $actid");
        $db->exec("DELETE FROM activity WHERE id = $actid");
        return $result;
    } catch (Exception $e) {
        $db->rollBack();
        return false;
    }
}
//输入表名
//$table可以是一个表的名字也可以是sql的一个查询表
function countNum($table){
	global $db;	
	$res = $db->query("select count(*) from ".$table);
	$result = $res->fetch();
	return empty($result)?0:$result[0];
}

//根据一个条件来查询
function countNumbyConditoin($table, $array){
	global $db;	
	
	$condition = '';
	foreach ($array as $name => $item)
		$condition = $condition."$name = '$item' and ";
	$condition = $condition." 1 = 1 ";	
	
	$res = $db->query("select count(*) from $table where ".$condition);
	$result = $res->fetch();
	return empty($result)?0:$result[0];
}

//加为好友，成功返回true，失败返回false，输入两个用户的id，双向的，顺序无关
function addfriend($userA,$userB){
	if($userA == $userB)
		return false;
	$sql = "INSERT INTO friend VALUES(?,?)";
	return action($sql,array($userA,$userB));
}

//加入活动，成功返回true，失败返回false
function addInActivity($userID,$actID){
	$sql = "INSERT INTO joinin VALUES(?,?)";
	return action($sql,array($userID,$actID));
}

//增加活动，成功返回id，失败返回false
function addActivity($name,$info,$userID,$datetime,$datetimeE,$astart,$aend,$location){
	$sql_activity = "INSERT INTO activity VALUES(null,?,?,?,?,?,?,?,?)";
	$array_activity = array($name,$info,$userID,$datetime,$datetimeE,$astart,$aend,$location);
	if(action($sql_activity,$array_activity) == false)
		return false;
		
	$activityId = getLastInsertId();	
	return (addInActivity($userID,$activityId)?$activityId:false);
}

function searchUser($target) {
    global $db;
    try {
        $res = $db->query("select * from user where userName = '$target'");
        $isfind = false;

        foreach($res as $row)
            if($row[1] == $target){
                $isfind = true;
                break;
            }

        if ($isfind){
            $user = new user($row);
            return $user;
        }else{
            $user = null;
            return false;
        }

    } catch (Exception $e) {
        $db->rollBack();
        return false;
    }
}

//************************************************慎用的函数******************************************************
//getDataById($type,$table,$id)						//$table是表名，$type是反射类型，成功返回type类型的对象数组
//getEarlyData($type, $table, $start, $count = 20)  //拿到最近的类,第start开始的count个，从0开始，成功返回type类型的对象数组
//delete($table,$id)								//删除一个表里面id为$id的项，成功返回ture，失败返回false
//modify($table,$array,$id)							//修改id为$id的项的内容，array为('colname'=>'value')，成功返回ture，失败返回false
//deleteItems($table,$idname,$id)					//删除表里面id名字为$idname，值为$id的记录，好友的话为 'UserA'，$id
//**************************************************************************************************************

//use reflection class and prevent SQL injection
function getDataById($type,$table,$id) {
	global $db;
	
	if (!get_magic_quotes_gpc())
	$table = addslashes($table);
	
	$res = $db->query("select * from $table where id = $id");
    if( empty($res) )
        return false;
	$class = $type->newInstance($res->fetch());
	return $class;
}
function getDataByName($type,$table,$name) {
    global $db;

    if (!get_magic_quotes_gpc())
        $table = addslashes($table);

    $res = $db->query("select * from $table where userName = $name");
    if( empty($res) )
        return false;
    $class = $type->newInstance($res->fetch());
    return $class;
}

//想拿到user就$table = 'user',$type = new ReflectionClass('user');其他类推
function getEarlyData($type, $table, $start, $count = 20){
	$sql = "select * from $table
		order by Date desc 
		limit $start,$count";
	return getClassByInput($type,$sql,array());
}

function getEarlyDatabyConditoin($type, $table, $start, $count = 20,$array){
	$sql = "select * from $table where ";
	foreach ($array as $name => $item)
		$sql = $sql." $name = '$item' and ";
	$sql = $sql." 1 = 1 order by Date desc 
		limit $start,$count";
	return getClassByInput($type,$sql,array());
}

function modify($table,$array,$id){
	global $db;
	try {
		$sql = "UPDATE $table SET ";
		foreach($array as $name => $value)
			$sql = $sql."$name = '$value',";
		$sql = $sql."id = $id where id = $id";
		$result = $db->exec($sql);
        return $result;
	} catch (Exception $e) {
		$db->rollBack();
		return false;
	}
}

//******************************************很少用的函数**********************************************************
//getClassByInput($type,$sql,$array)
//action($sql,$array)
//isrecord($sql,$array)
//**************************************************************************************************************
function getClassByInput($type,$sql,$array) {
	global $db;
	$result = array();
	$sth = $db->prepare($sql);
	$sth->execute($array);
	$res = $sth->fetchAll();
	foreach($res as $item){
		$class = $type->newInstance($item);
		array_push($result, $class);
	}	
	return $result;
}

function action($sql,$array){
	global $db;
	try {	
		foreach($array as $item)
			$item = addslashes($item);
		
		$sth = $db->prepare($sql);
		return $sth->execute($array);

	} catch (Exception $e) {
		$db->rollBack();
		return false;
	}
}

function isrecord($sql,$array){
	global $db;
	$result = array();
	$sth = $db->prepare($sql);
	$sth->execute($array);
	$res = $sth->fetch();
	return !empty($res);
}

function getLastInsertId(){
	global $db;
	return $db->lastInsertId();
}
?>