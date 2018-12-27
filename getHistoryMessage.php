<?php
header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];
@$userID=$_GET['userID'];

$data = array();

$tableName = "tb_msg_".$userID;

header('Content-Type:text/html charset=utf-8;');

if($useServer){
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
    
}
else{
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}

mysql_select_db("db_message",$myLink);

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
