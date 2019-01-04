<?php
header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];
@$itemID=$_GET['itemID'];
@$messageReceiveUserID=$_GET['messageReceiveUserID'];
@$messageSendUserID=$_GET['messageSendUserID'];

/*
 *@php 获取用户的新消息列表
 *@$_GET 接受的数据
 *@var array $data 回传的数据，是一个详细消息列表
 */
$data = array();

//数据表的名称为tb_msg_加上用户的ID
$tableName = "tb_msg_".$messageReceiveUserID;

//连接和选择数据库
header('Content-Type:text/html charset=utf-8;');

if($useServer){
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
    
}
else{
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}

mysql_select_db("db_message",$myLink);

//选取messageIsRead=0即未读的消息，生成详细消息列表
$sql="select * from ".$tableName." where itemID=$itemID AND messageReceiveUserID=$messageReceiveUserID AND messageSendUserID=$messageSendUserID AND messageIsRead = 0 order by messageSendTime ASC";
$result = mysql_query($sql, $myLink);

while($take = mysql_fetch_array($result)){
    $tempData = array();
    $tempData['itemID']=intVal($itemID);
    $tempData['messageReceiveUserID']=intVal($messageReceiveUserID);
    $tempData['messageSendUserID']=intVal($messageSendUserID);
    $tempData['messageInput']=$take['messageInput'];
    $tempData['messageSendTime']=$take['messageSendTime'];
    array_push($data,$tempData);
}

//选取messageIsRead=0即未读的消息之后，将未读置为已读
$sql="update ".$tableName." set messageIsRead=1 where itemID=$itemID AND messageReceiveUserID=$messageReceiveUserID AND messageSendUserID=$messageSendUserID";
$result = mysql_query($sql, $myLink);

mysql_free_result($result);
header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);

?>