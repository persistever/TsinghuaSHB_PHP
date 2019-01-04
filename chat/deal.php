<?php
header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];
@$itemID=intval($_GET['itemID']);
@$itemUserID=intval($_GET['itemUserID']);
@$itemBuyerID=intval($_GET['itemBuyerID']);
@$thisUserID=intval($_GET['thisUserID']);

/*
 *@php 买卖双方在chat页面进行交易确认
 *@$_GET 接受的数据
 *@var array $data 回传的数据 
 */

$data = array();

//连接和选择数据库
header('Content-Type:text/html charset=utf-8;');

if($useServer){
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}
else{
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}

mysql_select_db("db_try1",$myLink);

//如果该用户是买家，就把买家的ID更新到数据库中对应的itemID和itemUserID的位置
if($itemBuyerID==$thisUserID){  
    $sql="update tb_trade set itemBuyerID=$itemBuyerID where itemID=$itemID AND userID=$itemUserID";
    $result = mysql_query($sql, $myLink);
    if($result){
        $data['status'] = 'success';
        $data['itemBuyerID'] = $itemBuyerID;
        $data['itemIsSold'] = 0;
    } else {
        $data['status'] = 'failed';
    }
    mysql_free_result($result);
//如果该用户是卖家，就查看买家的ID是否和聊天页面的用户是一位用户，如果是，就完成交易确认
} elseif($itemUserID==$thisUserID){
    $sql="select * from tb_trade where itemID=$itemID AND userID=$itemUserID";
    $result = mysql_query($sql, $myLink);
    $take = mysql_fetch_array($result);
    $tempBuyerID = intval($take['itemBuyerID']);
    if($tempBuyerID == $itemBuyerID){
        $sql="update tb_trade set itemIsSold=1 where itemID=$itemID AND userID=$itemUserID";
        $result1 = mysql_query($sql, $myLink);
        if($result1){
            $data['status'] = 'success';
            $data['itemIsSold'] = 1;
        } else {
            $data['status'] = 'failed';
        }
        mysql_free_result($result1);
    }
    mysql_free_result($result);
}


header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);


?>