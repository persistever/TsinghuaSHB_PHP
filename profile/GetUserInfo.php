<?php
header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];
@$userID=intval($_GET['userID']);

/*
 *@php 获取用户的系统评分
 *@$_GET 接受的数据
 *@var array $data 回传的数据
 */
include "../ConnectDataBase.php";

$data = array();
//连接和选择数据库
$myLink = ConnectDataBase($useServer);
header('Content-Type:text/html charset=utf-8;');

mysql_select_db("db_try1",$myLink);

$sql = "select * from tb_user where userID=$userID";
$result = mysql_query($sql,$myLink);
$take = mysql_fetch_array($result);

//获取用户的系统评分
$data['userGrade'] = $take['userGrade'];

mysql_free_result($result);

header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);

?>