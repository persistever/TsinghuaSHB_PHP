<?php
header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];
@$deleteUserID=intval($_GET['delete_userid']);
@$itemID=intval($_GET['delete_itemid']);
@$messageUserID=intval($_GET['thisUserID']);

include "ConnectDataBase.php";

$data = array();

$myLink = ConnectDataBase($useServer);
header('Content-Type:text/html charset=utf-8;');

mysql_select_db("db_message",$myLink);

$tableName = "tb_msg_".$messageUserID;

$sql="delete from ".$tableName." where itemID = $itemID AND (messageReceiveUserID = $deleteUserID OR messageSendUserID = $deleteUserID)";
$result = mysql_query($sql, $myLink);

if($result){
    $data['status'] = 'success';
} else {
    $data['status'] = 'failed';
}
mysql_free_result($result);
header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);

?>