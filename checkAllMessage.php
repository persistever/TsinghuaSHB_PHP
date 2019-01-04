<?php
header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];
@$messageUserID=$_GET['messageUserID'];

/*
 *@php 获取用户的消息列表
 *@$_GET 接受的数据
 *@var array $data 回传的数据，是一个消息列表
 */

$data = array();

//数据表的名称为tb_msg_加上用户的ID
$tableName = "tb_msg_".$messageUserID;

//连接和选择数据库
header('Content-Type:text/html charset=utf-8;');

if($useServer){
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}
else{
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}

mysql_select_db("db_message",$myLink);

//从消息中选择不同其他用户发送的最新消息，组成列表
$sql="select * from ".$tableName." a where a.messageSendTime in (SELECT max(messageSendTime) from ".$tableName." group by itemID,messageName ) order by messageSendTime DESC";

$result = mysql_query($sql, $myLink);

while($take = mysql_fetch_array($result)){
    $tempData = array();
    $tempData['itemID']=intVal($take['itemID']);
    //需要判断消息的发送接收方向
    if(intVal($take['messageReceiveUserID'])==intVal($messageUserID)){
        $tempData['messageTheOtherUserID']=intVal($take['messageSendUserID']);  
    } else {
        $tempData['messageTheOtherUserID']=intVal($take['messageReceiveUserID']);
    }
    
    $tempData['message']=$take['messageInput'];
    $tempData['messageSendTime']=$take['messageSendTime'];
    $tempData['messageIsRead']=$take['messageIsRead'];
    
    //返回的消息中需要包含用户的微信昵称和头像
    mysql_select_db("db_try1",$myLink);
    
    $sql="select userNickName,userIconPath from tb_user where userID=".$tempData['messageTheOtherUserID'];
    $result2 = mysql_query($sql, $myLink);
    $take2 = mysql_fetch_array($result2);
    $tempData['userNickName'] = $take2['userNickName'];
    $tempData['userIconPath'] = $take2['userIconPath'];
    
    array_push($data,$tempData);
    mysql_free_result($result2);
}

mysql_free_result($result);
header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);

?>