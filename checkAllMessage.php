<?php
header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];
@$messageUserID=$_GET['messageUserID'];


$data = array();

$tableName = "tb_msg_".$messageUserID;

header('Content-Type:text/html charset=utf-8;');

if($useServer){
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}
else{
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}

mysql_select_db("db_message",$myLink);

$sql="select * from ".$tableName." group by itemID,messageReceiveUserID,messageSendUserID order by messageSendTime DESC";

$result = mysql_query($sql, $myLink);

while($take = mysql_fetch_array($result)){
    $tempData = array();
    $tempData['itemID']=intVal($take['itemID']);
    if(intVal($take['messageReceiveUserID'])==intVal($messageUserID)){
        $tempData['messageTheOtherUserID']=intVal($take['messageSendUserID']);  
    }
    else{
        $tempData['messageTheOtherUserID']=intVal($take['messageReceiveUserID']);
    }
    
    $tempData['message']=$take['messageInput'];
    $tempData['messageSendTime']=$take['messageSendTime'];
    $tempData['messageIsRead']=$take['messageIsRead'];
    array_push($data,$tempData);
}

mysql_free_result($result);
header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);

?>