<?php
include "ConnectDataBase.php";

header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];
@$itemID=$_GET['itemID'];
@$userID=$_GET['userID'];

$data = array();

$myLink = ConnectDataBase($useServer);
header('Content-Type:text/html charset=utf-8;');

mysql_select_db("db_try1",$myLink);

$sql = "delete from tb_buy where userID=$userID AND itemID=$itemID";
$result = mysql_query($sql,$myLink);

if($result){
    $data['status'] = 'success';
}else{
    $data['status'] = 'fail';
}

header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);

?>