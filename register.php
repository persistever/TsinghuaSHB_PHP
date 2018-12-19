<?php
header('Content-Type:application/json; charset=utf-8;');

@$userNickName = $_GET['userNickName'];
@$userEmail = $_GET['userEmail'];
@$userOpenID = $_GET['userOpenID'];
@$useServer = $_GET['useServer'];
$userRegisterDate = date("Y-m-d");
$userRegisterTime = date("h-i-s-a");
$haveRegister = NULL;
$data = NULL;

header('Content-Type:text/html charset=utf-8;');
if($useServer){
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}
else{
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}

mysql_select_db("db_try1",$myLink);

$sql="insert into tb_user
(userNickName,userOpenID,userEmail,userRegisterDate,userRegisterTime)
 values('$userNickName','$userOpenID','$userEmail','$userRegisterDate','$userRegisterTime')";
$result= mysql_query($sql,$myLink);
$result!=NULL?$haveRegister = true:$haveRegister = false;

$sql="select * from tb_user where userEmail='$userEmail'";
$result=mysql_query($sql,$myLink);
$take = mysql_fetch_array($result);
$userID=$take['userID'];



$data['haveRegister']=$haveRegister;
$data['userID']=$userID;

mysql_free_result($result);
header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);

?>