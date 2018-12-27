<?php
header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];
@$itemID=intval($_GET['itemID']);
@$itemUserID=intval($_GET['itemUserID']);
@$itemBuyerID=intval($_GET['itemBuyerID']);
@$thisUserID=intval($_GET['thisUserID']);

$data = array();

header('Content-Type:text/html charset=utf-8;');

if($useServer){
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}
else{
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}

mysql_select_db("db_try1",$myLink);

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