<?php
header('Content-Type:application/json; charset=utf-8;');
$totalIndex=$_GET['totalIndex'];
$useServer=$_GET['useServer'];
$serverURL=$_GET['serverURL'];
$data = array();
for($i=0;$i<$totalIndex;$i++){
    $data[$i]=array();
}

header('Content-Type:text/html charset=utf-8;');

if($useServer){
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
    
}
else{
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}

$serverPath=$serverURL.'Pictures/';
mysql_select_db("db_try1",$myLink);
$result = mysql_query("select * from tb_item");
if($result){
    $data['fetch data']='success';
}
else{
    $data['fetch data']='fail';
}

$index=null;

while($take = mysql_fetch_array($result)){
    $tempData=array();
    if(strcmp($take['itemSubject'],"理科")==0){$index=1;}
    elseif(strcmp($take['itemSubject'],"工科")==0){$index=2;}
    elseif(strcmp($take['itemSubject'],"文科")==0){$index=3;}
    elseif(strcmp($take['itemSubject'],"其它")==0){$index=4;}
    //$index=0;
    $tempData['itemName']=$take['itemName'];
    $tempData['itemCoverPath']=$serverPath.$take['itemPicturePath0'];
    $tempData['itemPrice']=$take['itemPrice'];
    $tempData['itemShortInfo']=$take['itemShortInfo'];
    $tempData['itemID']=$take['itemID'];
    
    $tempItemID = intval($take['itemID']);
    $sql = "select * from tb_trade where itemID=$tempItemID";
    $result1 = mysql_query($sql,$myLink);
    $take1 = mysql_fetch_array($result1);
    
    if(intval($take1['itemIsSold'])==0 && intval($take1['itemIsPublished'])==1 &&  intval($take1['itemIsDelete'])==0){
        array_push($data[$index],$tempData);
        
        $randTemp=rand(0,1);
        if($randTemp==1) array_push($data[0],$tempData);
    }
    mysql_free_result($result1);
}

mysql_free_result($result);

header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);

?>