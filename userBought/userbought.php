<?php
header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];
@$serverURL=$_GET['serverURL'];
@$userID=$_GET['userID'];

/*
 *@php 获取用户的购买记录
 *@$_GET 接受的数据
 *@var array $data 回传的数据，是一个购买书籍资料的列表
 */
include "../ConnectDataBase.php";

$data = array();
//连接和选择数据库
$myLink = ConnectDataBase($useServer);
header('Content-Type:text/html charset=utf-8;');
mysql_select_db("db_try1",$myLink);

//返回的图片网络目录地址
$serverPath=$serverURL.'Pictures/';

//查找买家ID等于该用户ID，并且itemIsSold=1，已经完成交易的书籍资料信息
$sql = "select * from tb_trade where itemBuyerID=$userID AND itemIsSold=1";
$result = mysql_query($sql,$myLink);
while($take = mysql_fetch_array($result)){
    
    $tempData=array();
    $tempData['itemID']=intval($take['itemID']);
    $tempData['isBuyerGraded']=intval($take['isBuyerGraded']);
    $itemID = intval($take['itemID']);
    
    $sql = "select * from tb_item where itemID=$itemID";
    $result2 = mysql_query($sql,$myLink);
    $take2 = mysql_fetch_array($result2);
    $tempData['itemPrice']=intval($take2['itemPrice']);
    $tempData['itemName']=$take2['itemName'];
    $tempData['itemCoverPath']=$serverPath.$take2['itemPicturePath0'];
    $tempData['itemShortInfo']=$take2['itemShortInfo'];
    mysql_free_result($result2);
    
    array_push($data,$tempData);
}

mysql_free_result($result);

header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);

?>