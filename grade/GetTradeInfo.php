<?php
header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];
@$userID=intval($_GET['userID']);
@$itemID=intval($_GET['itemID']);
@$sellOrBuy=intval($_GET['sellOrBuy']);

/*
 *@php 获取交易信息
 *@$_GET 接受的数据
 *@var array $data 回传的数据
 */

include "../ConnectDataBase.php";

$data = array();

//连接和选择数据库
$myLink = ConnectDataBase($useServer);
header('Content-Type:text/html charset=utf-8;');
mysql_select_db("db_try1",$myLink);

//@var bool $sellOrBuy ==0表示是sell，==1表示是buy
//如果$sellOrBuy==0表示是卖家sell页面对买家打分
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
//如果$sellOrBuy==0表示是买家buy页面对卖家打分
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