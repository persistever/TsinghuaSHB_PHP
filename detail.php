<?php
header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];
@$serverURL=$_GET['serverURL'];
@$itemID=$_GET['itemID'];
@$userID=$_GET['userID'];

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
$result = mysql_query("select * from tb_item where itemID=$itemID",$myLink);
$take = mysql_fetch_array($result);

$data['itemID']=intval($take['itemID']);
$data['itemUserID']=intval($take['itemUserID']);
$data['itemName']=$take['itemName'];
$data['itemPrice']=$take['itemPrice'];
$data['itemShortInfo']=$take['itemShortInfo'];
$data['itemSubject']=$take['itemSubject'];
$data['itemSortIsClass']=$take['itemSortIsClass'];
$data['itemSort']=$take['itemSort'];
$data['itemInfo']=$take['itemInfo'];
$data['itemPublisher']=$take['itemPublisher'];
$data['itemPublishVersion']=$take['itemPublishVersion'];
$data['itemCourseName']=$take['itemCourseName'];
$data['itemCourseNO']=$take['itemCourseNO'];
$data['itemCourseTeacher']=$take['itemCourseTeacher'];
$data['itemPublishTime']=$take['itemPublishTime'];
$data['itemPictureNO']=$take['itemPictureNO'];
$data['itemPicturePathList']=array();

$pictureP='itemPicturePath';
for($i=0;$i<intval($data['itemPictureNO']);$i++){
    $picturePath = $pictureP.$i;
    $pathURL = $serverPath.$take["$picturePath"];
    $data["$picturePath"]=$pathURL;
    array_push($data['itemPicturePathList'],$pathURL);
}

mysql_free_result($result);

$sql="select * from tb_buy where itemID=$itemID AND userID=$userID";
$result = mysql_query($sql,$myLink);
$take = mysql_fetch_array($result);
if($take){
    $data['itemIsLike']=intval($take['itemIsLike']);
    $data['itemIsBuy']=intval($take['itemIsBuy']);
}
else{
    $data['itemIsLike']=false;
    $data['itemIsBuy']=false;
}

$sql="select * from tb_trade where itemID=$itemID";
$result = mysql_query($sql,$myLink);
$take = mysql_fetch_array($result);
$data['itemIsSold'] = intval($take['itemIsSold']);
$data['itemIsPublished'] = intval($take['itemIsPublished']);
$data['itemIsDelete'] = intval($take['itemIsDelete']);

mysql_free_result($result);
header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);

?>