<?php
header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];
@$serverURL=$_GET['serverURL'];
@$userID=$_GET['userID'];
$zero = 0;
const echoNO = 20;

$data = array();

header('Content-Type:text/html charset=utf-8;');

if($useServer){
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
    
}
else{
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}

$serverPath=$serverURL.'Pictures/';
mysql_select_db("db_try1",$myLink);

$sql = "select * from tb_trade where userID=$userID AND itemIsDelete=$zero";
$result = mysql_query($sql,$myLink);

while($take = mysql_fetch_array($result)){
    
    $tempData=array();
    $tempData['itemID']=intval($take['itemID']);
    $itemID = intval($take['itemID']);
    $tempData['itemIsSold']=$take['itemIsSold'];
    $tempData['itemIsSoldChecked']=$serverPath.$take['itemIsSoldChecked'];
    $tempData['itemIsPublished']=$take['itemIsPublished'];
    $tempData['itemPublishTime']=$take['itemPublishTime'];
    $tempData['itemSoldTime']=$take['itemSoldTime'];
    $tempData['itemIsDelete']=$take['itemIsDelete'];
    
    $sql = "select * from tb_item where itemID=$itemID";
    $result2 = mysql_query($sql,$myLink);
    $take2 = mysql_fetch_array($result2);
    $tempData['itemPrice']=$take2['itemPrice'];
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