<?php
header('Content-Type:application/json; charset=utf-8;');

@$useServer = $_POST['useServer'];
@$num = $_POST['num'];
@$itemPublishTime = date("Y-m-d-h-i-s-a");
$data = NULL;

if($useServer){
    $dataBasePath = "C:\HwsNginxMaster\wwwroot\TsinghuaSHB\Pictures\\";
}
else{
    $dataBasePath = "D:\Project\PHP\TsinghuaSHB\Pictures\\";
}
$fileType = end(explode(".",$_FILES['file']['name']));
$path = $dataBasePath."_TIME_".$itemPublishTime.'_'.$num.'.'.$fileType;
if(move_uploaded_file($_FILES['file']['tmp_name'], $path)){
    $data['path']= $path;
    $data['status'] = 'upload success';
}
else{
    $data['path']= $path;
    $data['status'] = 'upload failed';
}

echo json_encode($data);
/*
header('Content-Type:text/html; charset=utf-8;');
if($useServer){
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}
else{
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}

mysql_select_db("db_tsinghuashb",$myLink);

$sqlNameList='itemName,itemUserID,itemPrice,itemShortInfo,itemSubject,
itemSort,itemInfo,itemPublisher,itemPublishVersion,itemCoverPath,
itemCourseName,itemCourseNO,itemCourseTeacher,itemPictureNO,itemPicturePath1,
itemPicturePath2,itemPicturePath3';
$sqlValueList="$itemName,$itemUserID,$itemPrice,$itemShortInfo,$itemSubject,
$itemSort,$itemInfo,$itemPublisher,$itemPublishVersion,$itemCoverPath,
$itemCourseName,$itemCourseNO,$itemCourseTeacher,$itemPictureNO,$itemPicturePath1,
$itemPicturePath2,$itemPicturePath3";
$sql="insert into tb_stuff(".$sqlNameList.") values(".$sqlValueList.")";

mysql_query($sql,$myLink);
*/

?>