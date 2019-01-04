<?php
header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];
@$deleteUserID=intval($_GET['delete_userid']);
@$itemID=intval($_GET['delete_itemid']);
@$messageUserID=intval($_GET['thisUserID']);

/*
 *@php 删除用户和某个用户针对某件书籍资料的聊天记录
 *@$_GET 接受的数据
 *@var array $data 回传的数据，返回状态信息
 */

include "ConnectDataBase.php";

$data = array();
//连接和选择数据库
$myLink = ConnectDataBase($useServer);
header('Content-Type:text/html charset=utf-8;');
mysql_select_db("db_message",$myLink);

//消息数据表名称为tb_msg_加上用户的ID
$tableName = "tb_msg_".$messageUserID;

//删除itemID deleteUserID相对应的消息记录
$sql="delete from ".$tableName." where itemID = $itemID AND (messageReceiveUserID = $deleteUserID OR messageSendUserID = $deleteUserID)";
$result = mysql_query($sql, $myLink);

//如果删除成功，mysql_query将返回true的bool变量，否则返回false
if($result){
    $data['status'] = 'success';
} else {
    $data['status'] = 'failed';
}
mysql_free_result($result);
header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);

?>