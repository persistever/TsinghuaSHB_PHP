<!DOCTYPE html>
<html>
<body>
<?php
require_once ('php_mysql/MysqliDb.php');
$db = new MysqliDb (Array (
                'host' => 'localhost',  
                'username' => 'root', 
                'password' => 'usbw',
                'db'=> 'test2',  //数据库名
                'port' => 3307,  //端口号
                'charset' => 'utf8'));
if(!$db) die("Database error");  
$where = array(
                'id' => 1
            );
/*           
//插入一条数据          
$data = Array (
	'user_id' => '9',
    'user_name' => 'daasd',
	'user_code' => '231123',
	'user_authority' => '4',
);

$id = $db->insert ('user', $data);  //‘user'是表名
if($id)
    echo 'user was created. Id=' . $id;
*/
/*
//插入多条数据
$data = Array(
    Array (
    'user_id' => '10',
    'user_name' => 'das',
	'user_code' => '231123',
	'user_authority' => '4',
    ),
    Array (
    'user_id' => '11',
    'user_name' => 'dsd',
	'user_code' => '231123',
	'user_authority' => '4',
    )
);
$ids = $db->insertMulti('user', $data);
*/
/*
//更新一条数据
$data = Array (
	'user_code' => '12353a',
);
$db->where ('user_name', 'dsd');
if ($db->update ('user', $data))
    echo $db->count . ' records were updated';
else
    echo 'update failed: ' . $db->getLastError();
*/
//查询
$cols = Array ("user_name", "user_authority");  //设置查找的column
$db->where ("user_id", 1, '>');  //第三个值是operator，默认是‘==’，可以改成‘<'之类的
$users = $db->get ("user", null, $cols);
if ($db->count > 0)
    foreach ($users as $user) { 
        print_r ($user['user_name']); //通过$var[key]访问内容
        echo "</br>";
    }

?>

</body>
</html>