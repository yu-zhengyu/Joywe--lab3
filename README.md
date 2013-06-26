Joywe--lab3
===========
运行环境:  windows/linux都可以运行，需要安装有php服务器和mysql服务器


安装：
1. 在电脑上安装php服务器和mysql服务器，建议使用WampServer。
2.   在mysql服务器上新建一个数据库（建议将其命名为classparty）,编码方式设置为utf8，然后将classParty.sql文件导入到刚刚新建的数据库上。
3. 把源代码文件放到php服务器的虚拟目录（wamp\www）下。
4. 修改目录下的“control.php”：
$db = new PDO('mysql:host=127.0.0.1;dbname=classparty;charset=UTF-8', 'root', '');
第一个变量‘mysql:host=127.0.0.1’，请将其修改为对应的mysql服务器地址
第二个变量‘root’，表示对应的mysql的用户，请根据实际用户名进行修改
第三个变量‘’表示mysql用户对应的密码，请根据实际密码进行修改
$db = connect('root', '');
第一个变量“root”表示实际用户名，请根据实际数据库名字进行修改
第二个变量''表示数据库密码，请根据实际数据库密码进行修改
5. 使用浏览器（建议使用chrome)访问刚刚部署的文件夹就可以成功使用该系统。
6. 在进行访问时，首先运行control/data.php文件即可导入部分数据库数据，以便测试所用。
7. 测试账号，用户名：herong，密码：123456


如果在使用本系统过程中遇到问题可以联系： 445344611@qq.com


组长：吴嘉怡
组员：何梓荣   吴茵茵  郑彧
