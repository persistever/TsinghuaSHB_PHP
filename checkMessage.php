<?php
header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];
@$itemID=$_GET['itemID'];
@$messageReceiveUserID=$_GET['messageReceiveUserID'];
@$messageSendUserID=$_GET['messageSendUserID'];


$data = array();

$tableName = "tb_msg_".$messageReceiveUserID;

header('Content-Type:text/html charset=utf-8;');

if($useServer){
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
    
}
else{
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}

mysql_select_db("db_message",$myLink);

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

$sql="update ".$tableName." set messageIsRead=1 where itemID=$itemID AND messageReceiveUserID=$messageReceiveUserID AND messageSendUserID=$messageSendUserID";
$result = mysql_query($sql, $myLink);

mysql_free_result($result);
header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);

?>