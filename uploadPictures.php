<?php
header('Content-Type:application/json; charset=utf-8;');

@$useServer = $_POST['useServer'];
@$itemID = $_POST['itemID'];
@$itemUserID = $_POST['itemUserID'];
@$itemPictureNO = $_POST['itemPictureNO'];
@$num = $_POST['num'];
@$itemPublishTime = date("Y-m-d-h-i-s-a");
$data = NULL;

$itemUserID = 2;
$itemID=intval($itemID);
$itemPictureNO=intval($itemPictureNO);

if($useServer){
    $dataBasePath = "C:\HwsNginxMaster\wwwroot\TsinghuaSHB\Pictures\\";
}
else{
    $dataBasePath = "D:\Project\PHP\TsinghuaSHB\Pictures\\";
}

$fileType = end(explode(".",$_FILES['file']['name']));
$itemPath = "_ITEMID_".$itemID."_USERID_".$itemUserID."_TIME_".$itemPublishTime.'_'.$num.'.'.$fileType;

$path = $dataBasePath.$itemPath;
if(move_uploaded_file($_FILES['file']['tmp_name'], $path)){
    $data['path']= $path;
    $data['status'] = 'upload success';
}
else{
    $data['path']= $path;
    $data['status'] = 'upload failed';
}

header('Content-Type:text/html charset=utf-8;');
if($useServer){
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}
else{
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}

mysql_select_db("db_try1",$myLink);
$numtemp = $num-1;
$itemPicturePathName = 'itemPicturePath'.$numtemp;

$sql="update tb_item set itemPictureNO=$itemPictureNO, ".$itemPicturePathName."='$itemPath' where itemID=$itemID";

$result = mysql_query($sql,$myLink);

if($result){
    $data['updateSQLStatus']='success';
}
else{
    $data['updateSQLStatus']='fail';
}
$data['itemPicturePathName']=$itemPicturePathName;
$data['itemPath']=$itemPath;
$data['itemPictureNO']=$itemPictureNO;
$data['itemID']=$itemID;
mysql_free_result($result);

header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);

?>