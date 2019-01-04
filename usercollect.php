<?php
header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];
@$serverURL=$_GET['serverURL'];
@$userID=$_GET['userID'];

/*
 *@php 获取用户收藏记录列表
 *@$_GET 接收的数据
 *@var array $data 回传的数据
 */

include "ConnectDataBase.php";

$data = array();
//连接和选择数据库
$myLink = ConnectDataBase($useServer);
header('Content-Type:text/html charset=utf-8;');

$serverPath=$serverURL.'Pictures/';
mysql_select_db("db_try1",$myLink);

//查找对应用户已经收藏的记录，同时返回该商品的部分信息和出售发布状态
$sql = "select * from tb_buy where userID=$userID AND itemIsLike=1";
$result = mysql_query($sql,$myLink);
while($take = mysql_fetch_array($result)){
    
    $tempData=array();
    $tempData['itemID']=intval($take['itemID']);
    $itemID = intval($take['itemID']);
    $tempData['itemUserID'] = intval($take['itemUserID']);
    $tempData['itemIsBuy'] = intval($take['itemIsBuy']);
    $tempData['itemIsSoldChecked']=$serverPath.$take['itemIsSoldChecked'];
    $tempData['itemBuyTime']=$take['itemBuyTime'];
    $tempData['itemServerCheckTime']=$take['itemServerCheckTime'];
    
    $sql = "select * from tb_item where itemID=$itemID";
    $result2 = mysql_query($sql,$myLink);
    $take2 = mysql_fetch_array($result2);
    $tempData['itemPrice']=intval($take2['itemPrice']);
    $tempData['itemName']=$take2['itemName'];
    $tempData['itemCoverPath']=$serverPath.$take2['itemPicturePath0'];
    $tempData['itemShortInfo']=$take2['itemShortInfo'];
    mysql_free_result($result2);
    
    $sql = "select * from tb_trade where itemID=$itemID";
    $result2 = mysql_query($sql,$myLink);
    $take2 = mysql_fetch_array($result2);
    $tempData['itemIsSold']=intval($take2['itemIsSold']);
    $tempData['itemIsPublished']=intval($take2['itemIsPublished']);
    $tempData['itemIsDelete']=intval($take2['itemIsDelete']);
    
    mysql_free_result($result2);
    array_push($data,$tempData);
}

mysql_free_result($result);

header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);


?>