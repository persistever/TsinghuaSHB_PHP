<?php
header('Content-Type:application/json; charset=utf-8;');
@$useServer = $_GET['useServer'];
@$itemID = intval($_GET['itemID']);
@$userID = intval($_GET['userID']);
@$itemIsLike = intval($_GET['itemIsLike']);

/*
 *@php 给用户添加收藏记录
 *@$_GET 接收的数据
 *@var array $data 回传的数据
 */

$data = array();
$itemUserID = null;
$itemIsSoldChecked = null;
$itemServerCheckTime =null;
//连接和选择数据库
header('Content-Type:text/html charset=utf-8;');
if($useServer){
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}
else{
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}

//先获取该书籍资料的信息
mysql_select_db("db_try1",$myLink);
$sql="select * from tb_trade where itemID=$itemID";
$result = mysql_query($sql,$myLink);
$take = mysql_fetch_array($result);

$itemUserID = intval($take['userID']);
$itemIsSoldChecked = intval($take['itemIsSoldChecked']);
$itemServerCheckTime = $take['itemServerCheckTime'];

//尝试查询收藏记录，如果有记录，说明之前已经添加过收藏信息，对收藏状态进行更改
//如果之前没有添加收藏信息，就进行添加并收藏的操作
$sql = "select * from tb_buy where itemID=$itemID AND userID=$userID";
$result = mysql_query($sql,$myLink);
$take = mysql_fetch_array($result);

if($take){
    if($itemIsLike){
        $sql = "update tb_buy set itemIsLike=0 where itemID=$itemID AND userID=$userID";
        $itemIsLike = 0;
    }
    else{
        $sql = "update tb_buy set itemIsLike=1 where itemID=$itemID AND userID=$userID";
        $itemIsLike = 1;
    }
    mysql_query($sql,$myLink);
}
else{
    $itemIsLike = 1;
    $sql = "insert into tb_buy(userID,itemID,itemUserID,itemIsLike,itemIsSoldChecked,itemServerCheckTime) values($userID,$itemID,$itemUserID, $itemIsLike ,$itemIsSoldChecked,'$itemServerCheckTime')";
    $result1 = mysql_query($sql,$myLink);
    if($result1){
        $itemIsLike = 1;
    }
    else{
        $itemIsLike = 0;
    }
    mysql_free_result($result1);
}

$data['itemIsLike']=$itemIsLike;
$data['itemIsSoldChecked']=$itemIsSoldChecked;
$data['itemServerCheckTime']=$itemServerCheckTime;
$data['itemID']=$itemID;
$data['itemUserID']=$itemUserID;
$data['userID']=$userID;


mysql_free_result($result1);
header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);


?>