<?php

include "ConnectDataBase.php";

header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];
@$itemID=intval($_GET['itemID']);
@$userID=intval($_GET['userID']);
@$status=intval($_GET['status']);

$data = array();

$myLink = ConnectDataBase($useServer);
header('Content-Type:text/html charset=utf-8;');

mysql_select_db("db_try1",$myLink);

switch($status){
    case -1:
        $sql = "update tb_trade set itemIsPublished=1 where userID=$userID AND itemID=$itemID";
        $result = mysql_query($sql,$myLink);
        break;
//     case 0:
//         $sql = "update tb_trade set itemIsSold=1 where userID=$userID AND itemID=$itemID";
//         $result = mysql_query($sql,$myLink);
//         break;
    case 0:
        $sql = "update tb_trade set itemIsDelete=1 where userID=$userID AND itemID=$itemID";
        $result = mysql_query($sql,$myLink);
        break;
    case 1:
        $sql = "update tb_trade set itemIsPublished=0 where userID=$userID AND itemID=$itemID";
        $result = mysql_query($sql,$myLink);
        break;
    default:
        $data['error'] = 'input error';
        break;        
}

if($result){
    $data['status'] = 'success';
}else{
    $data['status'] = 'fail';
}

header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);

?>