<?php
header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];
@$userID=intval($_GET['userID']);
@$grade=intval($_GET['grade']);
@$itemID=intval($_GET['itemID']);
@$sellOrBuy=intval($_GET['sellOrBuy']);

include "../ConnectDataBase.php";

$deltaGrade = 0;

$myLink = ConnectDataBase($useServer);
header('Content-Type:text/html charset=utf-8;');
mysql_select_db("db_try1",$myLink);

$deltaGrade = intval(($grade*1.0-80.0)/4.0);

$sql="select * from tb_user where userID=$userID";
$result = mysql_query($sql,$myLink);
$take = mysql_fetch_array($result);

$grade = intval($take['userGrade'])+$deltaGrade;
if($grade<0){
    $grade=0;
    
} elseif($grade>100){
    $grade=100;
}

if($grade<60){
    $sql="update tb_user set userIsBlocked=1 where userID=$userID";
    $result = mysql_query($sql,$myLink);
    mysql_free_result($result);
}

$sql="update tb_user set userGrade=$grade where userID=$userID";
$result = mysql_query($sql,$myLink);
mysql_free_result($result);

$boolState=1;
if($sellOrBuy==0){
    $sql="update tb_trade set isSellerGraded=$boolState where itemBuyerID=$userID AND itemID=$itemID AND itemIsSold=1";
    $result = mysql_query($sql,$myLink);
    mysql_free_result($result);
} elseif($sellOrBuy==1){
    $sql="update tb_trade set isBuyerGraded=$boolState where userID=$userID AND itemID=$itemID AND itemIsSold=1";
    $result = mysql_query($sql,$myLink);
    mysql_free_result($result);
}



?>