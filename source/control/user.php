<?php
class User {
	public $id;
	public $name;
    public $password;
	public $email;
    public $phone;
    public $info;
    public $picPath;
	public $createTime;
	public $sex;
	public $birth;
	public $city;

	public function __construct($data) {		
		$this->id = (int)$data[0];
		$this->name = $data[1];
        $this->password = $data[2];
		$this->email = $data[3];
        $this->phone = $data[4];
        $this->info = $data[5];
        $this->picPath = $data[6];
		$this->createTime = $data[7];
		$this->sex = $data[8];
		$this->birth = $data[9];
		$this->city = $data[10];
	}
	
	public function getActivities() {
		$sql = "select activity.* from activity,joinin 
		where joinin.UserID = ? and activity.id = joinin.ActID;
		order by Date desc";
		$type = new ReflectionClass('Activity');
		return getClassByInput($type,$sql,array($this->id));
	}
	
	public function getActivityNum(){
		$table = "(select activity.* from activity,joinin 
		where joinin.Userid = $this->id and joinin.ActID = activity.id) temp";
		return countNum($table);
	}
	
	public function getFriends() {
		$sql = "select user.*
		from user,friend
		where (user.id = friend.UserB and friend.UserA = ?)
		order by Date desc";
		$type = new ReflectionClass('User');
		return getClassByInput($type,$sql,array($this->id));
	}
	
	public function getFriendNum(){
		$table = "(select user.*
		from user,friend
		where (user.id = friend.UserB and friend.UserA = $this->id)) temp";
		return countNum($table);
	}

	public function isInActivity($ActID) {
		$sql = "select 1 from joinin
		where joinin.UserID = ? and joinin.ActID = ?";
		return isrecord($sql,array($this->id, $ActID));
	}

	public function isFriend($id) {
		$sql = "select 1
		from friend
		where (friend.UserA = ? and friend.UserB = ?) or (friend.UserA = ? and friend.UserB = ?)";
		return isrecord($sql,array($this->id,$id,$id,$this->id));
	}
}
?>