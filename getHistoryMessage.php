<?php
header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];
@$userID=$_GET['userID'];

/*
 *@php 删除用户的所有历史数据（即已读或者发送的消息）
 *@$_GET 接收的数据
 *@var array $data 回传的数据，历史消息列表
 */
$data = array();

//消息数据表的名称为tb_msg_加上用户ID
$tableName = "tb_msg_".$userID;

//连接和选择数据库
header('Content-Type:text/html charset=utf-8;');

if($useServer){
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
    
}
else{
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}

mysql_select_db("db_message",$myLink);

//查找已读或者发送的消息，并且按照时间顺序排序返回结果
$sql = "select * from ".$tableName." where messageIsRead= 1 order by messageSendTime ASC";
$result = mysql_query($sql, $myLink);
while($take = mysql_fetch_array($result)){
    $tempData = array();
    $tempData['itemID']=intVal($take['itemID']);
    $tempData['messageReceiveUserID']=intVal($take['messageReceiveUserID']);
    $tempData['messageSendUserID']=intVal($take['messageSendUserID']);
    $tempData['messageInput']=$take['messageInput'];
    $tempData['messageSendTime']=$take['messageSendTime'];
    $tempData['messageName']=$take['messageName'];
    array_push($data,$tempData);
};

mysql_free_result($result);
header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);

?>
