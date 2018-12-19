<?php
header('Content-Type:application/json; charset=utf-8;');

@$itemName = $_GET['itemName'];
@$itemPrice = $_GET['itemPrice'];
@$itemSubject = $_GET['itemSubject'];
@$itemSortIsClass = $_GET['itemSortIsClass'];
@$itemSort = $_GET['itemSort'];
@$itemInfo = $_GET['itemInfo'];
@$itemPublisher = $_GET['itemPublisher'];
@$itemPublishVersion = $_GET['itemPublishVersion'];
@$itemCourseName = $_GET['itemCourseName'];
@$itemCourseNO = $_GET['itemCourseNO'];
@$itemCourseTeacher = $_GET['itemCourseTeacher'];
@$itemUserID = $_GET['itemUserID'];
@$useServer = $_GET['useServer'];

//$itemUserID = 2;

$data=array();

$itemPrice = intval($itemPrice);

@$itemPublishTime=date("Y-m-d-H-i-s");
$itemShortInfo=NULL;
$subjectList=array("理科", "工科", "文科", "其它");
$itemSubject=$subjectList[$itemSubject];


$isClass=array("课程","非课程");
$itemSortIsClass=$isClass[$itemSortIsClass];
if(strcmp($itemSortIsClass,"课程")==0){
    $itemSortList=array("课本","讲义","作业","参考书","其他");
    $itemSort=$itemSortList[$itemSort];
    $itemShortInfo=$itemCourseName." ".$itemCourseTeacher." ".$itemSort;
}
else{
    $itemSortList=array("科技","艺术","人文社科","经济金融","其他");
    $itemSort=$itemSortList[$itemSort];
    $itemShortInfo=$itemCourseName." ".$itemCourseTeacher." ".$itemSort;
}

header('Content-Type:text/html; charset=utf-8;');
if($useServer){
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}
else{
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}
mysql_select_db("db_try1",$myLink);

$result=mysql_query("insert into tb_item(
itemName,itemUserID,itemPrice,itemShortInfo,itemSubject,
itemSortIsClass,itemSort,itemInfo,itemPublisher,itemPublishVersion,
itemCourseName,itemCourseNO,itemCourseTeacher,itemPublishTime) values(
'$itemName',$itemUserID,$itemPrice,'$itemShortInfo','$itemSubject',
'$itemSortIsClass','$itemSort','$itemInfo','$itemPublisher','$itemPublishVersion',
'$itemCourseName','$itemCourseNO','$itemCourseTeacher','$itemPublishTime')" ,$myLink);

if($result){
    $data['insertStatus']= true;
}
else{
    $data['insertStatus']= false;
}

$sql="select * from tb_item where itemUserID=$itemUserID AND itemPublishTime='$itemPublishTime'";
$result=mysql_query($sql,$myLink);
$take = mysql_fetch_array($result);

if($take){
    $data['selectStatus']= true;
    $data['itemID']= $take['itemID'];
    $itemID = $data['itemID'];
    $sql="insert into tb_trade(userID,itemID,itemPublishTime) values($itemUserID,$itemID,'$itemPublishTime')";
    mysql_query($sql,$myLink);
}
else{
    $data['selectStatus']= false;
}

mysql_free_result($result);

header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);
?>