<?php
header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];
@$itemID=$_GET['itemID'];
@$userID=$_GET['userID'];

/*
 *@php 删除用户的某条收藏记录
 *@$_GET 接受的数据
 *@var array $data 回传的数据，返回状态信息
 */

include "ConnectDataBase.php";
$data = array();

//连接和选择数据库
$myLink = ConnectDataBase($useServer);
header('Content-Type:text/html charset=utf-8;');
mysql_select_db("db_try1",$myLink);

//删除userID和itemID相对应的收藏记录
$sql = "delete from tb_buy where userID=$userID AND itemID=$itemID";
$result = mysql_query($sql,$myLink);

//成功的话mysql_query会返回true的bool变量，否则为false
if($result){
    $data['status'] = 'success';
}else{
    $data['status'] = 'fail';
}

header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);

?>