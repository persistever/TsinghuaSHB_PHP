<?php
header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];
@$itemID=$_GET['itemID'];
@$messageReceiveUserID=$_GET['messageReceiveUserID'];
@$messageSendUserID=$_GET['messageSendUserID'];
@$messageInput=$_GET['messageInput'];

$data = array();
$messageSendTime = date("Y-m-d-h-i-s-a");
$tableName = "tb_msg_".$messageSendUserID;

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
   messageSendTime VARCHAR(50))";

$result = mysql_query($sql, $myLink);


$sql="insert into ".$tableName."(itemID,messageReceiveUserID,messageSendUserID,messageInput,messageIsRead,messageSendTime) values($itemID, $messageReceiveUserID, $messageSendUserID,'$messageInput', 1 , '$messageSendTime')";
$result = mysql_query($sql, $myLink);

//$sql = "update tb_searchhot set searchHotKeyNO=$num where searchHotKeyName='$tempKey'";

if($result){
    $data['status']=true;
}
else{
    $data['status']=false;
}


$data['tableName'] = $tableName;
$data['messageSendTime'] = $messageSendTime;

$tableName = "tb_msg_".$messageReceiveUserID;
$sql="CREATE TABLE IF NOT EXISTS ".$tableName."(
   messageID INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
   itemID INT(10) UNSIGNED,
   messageReceiveUserID INT(10) UNSIGNED,
   messageSendUserID INT(10) UNSIGNED,
   messageInput VARCHAR(200),
   messageIsRead TINYINT(1),
   messageSendTime VARCHAR(50))";

$result = mysql_query($sql, $myLink);

$sql="insert into ".$tableName."(itemID,messageReceiveUserID,messageSendUserID,messageInput,messageIsRead,messageSendTime) values($itemID, $messageReceiveUserID, $messageSendUserID ,'$messageInput', 0 , '$messageSendTime')";
$result = mysql_query($sql, $myLink);

mysql_free_result($result);
header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);

?>