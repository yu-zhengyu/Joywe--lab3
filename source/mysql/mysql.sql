# 建表
set names utf8;
set character_set_database = utf8;
set character_set_server = utf8;
USE classParty;

#
# Table structure for table 'user'
# 
# id + 用户名 + 密码 +　个人信息 + 头像地址 + 是否活动管理员 + 注册时间 + 性别 + 出生年月 + 所在城市
CREATE TABLE user (
	id int(8) unsigned NOT NULL auto_increment,
	UserName varchar(32) NOT NULL ,
	Password varchar(32)  NOT NULL ,
	Email varchar(40) NOT NULL,
	Phone varchar(12) NOT NULL,
	Info text NOT NULL ,
	PicPath varchar(32) NOT NULL ,
	Date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,   
	Sex char(1) NOT NULL DEFAULT 'M',
	Birth date DEFAULT '1970-01-01',
	City varchar(20) NOT NULL DEFAULT '广州',
	
	PRIMARY KEY (id),
	KEY UserName (UserName(32))
);

#
# Table structure for table 'friend'
#
# 用户归属组： 用户1’id + 用户2’id
CREATE TABLE friend(
	UserA int(8) unsigned NOT NULL,
	UserB int(8) unsigned NOT NULL,

	PRIMARY KEY (UserA, UserB),
	FOREIGN KEY (UserA) REFERENCES user (id),
	FOREIGN KEY (UserB) REFERENCES user (id)
);

#
# Table structure for table 'activity'
#
# 活动：id + 活动名字 + 活动创建人 + 活动时间 + 活动地点 + 活动信息
CREATE TABLE activity(
	id int(32) unsigned NOT NULL auto_increment,
	ActName varchar(32) NOT NULL,
	ActInfo varchar(140) NOT NULL,
	UserID int(32) unsigned NOT NULL,
	ActTimeS date NOT NULL,
  ActTimeE date NOT NULL,
	startT int(4) NOT NULL,
	endT int(4) NOT NULL,
	ActLoc varchar(50) NOT NULL,
	
	PRIMARY KEY (id)
);

#
# Table structure for table 'joinin'
#
# 加入活动：用户id + 活动id
CREATE TABLE joinin(
	UserID int(8) unsigned NOT NULL,
	ActID int(8) unsigned NOT NULL,
	
	PRIMARY KEY (UserID, ActID),
	FOREIGN KEY (UserID) REFERENCES user (id),
	FOREIGN KEY (ActID) REFERENCES activity (id)
);