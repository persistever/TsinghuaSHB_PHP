<?php
header('Content-Type:application/json; charset=utf-8;');
@$useServer = $_GET['useServer'];
@$itemID = intval($_GET['itemID']);
@$userID = intval($_GET['userID']);
@$itemIsLike = intval($_GET['itemIsLike']);

$data = array();
$itemUserID = null;
$itemIsSoldChecked = null;
$itemIsSold = null;
$itemServerCheckTime =null;

header('Content-Type:text/html charset=utf-8;');
if($useServer){
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}
else{
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}

mysql_select_db("db_try1",$myLink);
$sql="select * from tb_trade where itemID=$itemID";
$result = mysql_query($sql,$myLink);
$take = mysql_fetch_array($result);

$itemUserID = intval($take['userID']);
$itemIsSold = intval($take['itemIsSold']);
$itemIsSoldChecked = intval($take['itemIsSoldChecked']);
$itemServerCheckTime = $take['itemServerCheckTime'];

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
    $sql = "insert into tb_buy(userID,itemID,itemUserID,itemIsLike,itemIsSoldChecked,itemIsSold,itemServerCheckTime) values($userID,$itemID,$itemUserID, $itemIsLike ,$itemIsSoldChecked,$itemIsSold,'$itemServerCheckTime')";
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