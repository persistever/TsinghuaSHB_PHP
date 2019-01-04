<?php
header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];
@$itemID=$_GET['itemID'];
@$messageReceiveUserID=$_GET['messageReceiveUserID'];
@$messageSendUserID=$_GET['messageSendUserID'];
@$messageInput=$_GET['messageInput'];
@$messageName=$_GET['messageName'];

/*
 *@php 聊天页面发送消息
 *@$_GET 接收的数据
 *@var array $data 回传的数据，返回是否成功保存到数据库的状态
 */

$data = array();
$messageSendTime = date("Y-m-d H:i:s");
$tableName = "tb_msg_".$messageSendUserID;

//连接和选择数据库
header('Content-Type:text/html charset=utf-8;');

if($useServer){
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
    
}
else{
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}

mysql_select_db("db_message",$myLink);

$sql="CREATE TABLE IF NOT EXISTS ".$tableName."(
   messageID INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
   itemID INT(10) UNSIGNED,
   messageReceiveUserID INT(10) UNSIGNED,
   messageSendUserID INT(10) UNSIGNED,
   messageInput VARCHAR(200),
   messageIsRead TINYINT(1),
   messageName VARCHAR(100),
   messageSendTime VARCHAR(50))";

$result = mysql_query($sql, $myLink);


$sql="insert into ".$tableName."(itemID,messageReceiveUserID,messageSendUserID,messageInput,messageIsRead,messageName,messageSendTime) values($itemID, $messageReceiveUserID, $messageSendUserID,'$messageInput', 1 ,'$messageName','$messageSendTime')";
$result = mysql_query($sql, $myLink);

if($result){
    $data['status']=true;
}
else{
    $data['status']=false;
}


$data['tableName'] = $tableName;
$data['messageSendTime'] = $messageSendTime;
//先更新接收者的消息列表
$tableName = "tb_msg_".$messageReceiveUserID;
$sql="CREATE TABLE IF NOT EXISTS ".$tableName."(
   messageID INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
   itemID INT(10) UNSIGNED,
   messageReceiveUserID INT(10) UNSIGNED,
   messageSendUserID INT(10) UNSIGNED,
   messageInput VARCHAR(200),
   messageIsRead TINYINT(1),
   messageName VARCHAR(100),
   messageSendTime VARCHAR(50))";

$result = mysql_query($sql, $myLink);
//再更新发送者的消息列表
$messageName = "msg_".$itemID."_".$messageSendUserID;
$sql="insert into ".$tableName."(itemID,messageReceiveUserID,messageSendUserID,messageInput,messageIsRead,messageName,messageSendTime) values($itemID, $messageReceiveUserID, $messageSendUserID ,'$messageInput', 0 , '$messageName','$messageSendTime')";
$result = mysql_query($sql, $myLink);

mysql_free_result($result);
header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);

?>