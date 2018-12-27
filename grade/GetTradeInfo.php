<?php
header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];
@$userID=intval($_GET['userID']);
@$itemID=intval($_GET['itemID']);
@$sellOrBuy=intval($_GET['sellOrBuy']);

include "../ConnectDataBase.php";

$data = array();

$myLink = ConnectDataBase($useServer);
header('Content-Type:text/html charset=utf-8;');
mysql_select_db("db_try1",$myLink);

if($sellOrBuy==0){
    $sql = "select * from tb_trade where userID=$userID AND itemID=$itemID AND itemIsSold=1";
    $result = mysql_query($sql,$myLink);
    $take = mysql_fetch_array($result);
    $tempUserID = intval($take['itemBuyerID']);
    
    $data['theOtherUserID']= $tempUserID;
    
    $sql = "select * from tb_user where userID=$tempUserID";
    $result1 = mysql_query($sql,$myLink);
    $take1 = mysql_fetch_array($result1);
    $data['theOtherUserNickName'] = $take1['userNickName'];
    mysql_free_result($result1);
    mysql_free_result($result);
    
}else{
    $sql = "select * from tb_trade where itemBuyerID=$userID AND itemID=$itemID AND itemIsSold=1";
    $result = mysql_query($sql,$myLink);
    $take = mysql_fetch_array($result);
    $tempUserID = intval($take['userID']);
    
    $data['theOtherUserID']= $tempUserID;
    
    $sql = "select * from tb_user where userID=$tempUserID";
    $result1 = mysql_query($sql,$myLink);
    $take1 = mysql_fetch_array($result1);
    $data['theOtherUserNickName'] = $take1['userNickName'];
    mysql_free_result($result1);
    mysql_free_result($result);
}

header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);

?>