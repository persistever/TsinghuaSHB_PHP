<?php
header('Content-Type:application/json; charset=utf-8;');
@$userNickName = $_GET['userNickName'];
@$userEmail = $_GET['userEmail'];
@$userOpenID = $_GET['userOpenID'];
@$userIconPath = $_GET['userIconPath'];
@$useServer = $_GET['useServer'];

/*
 *@php 用户注册
 *@$_GET 接收的数据
 *@var array $data 回传的数据，返回发布是否成功的状态和用户ID
 */
$data = array();
$userRegisterDate = date("Y-m-d");
$userRegisterTime = date("H:i:s");
$haveRegister = NULL;

//连接和选择数据库
header('Content-Type:text/html charset=utf-8;');
if($useServer){
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}
else{
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}

mysql_select_db("db_try1",$myLink);

//插入注册记录
$sql="insert into tb_user
(userNickName,userOpenID,userEmail,userIconPath,userRegisterDate,userRegisterTime)
 values('$userNickName','$userOpenID','$userEmail','$userIconPath','$userRegisterDate','$userRegisterTime')";
$result= mysql_query($sql,$myLink);
$result!=NULL?$haveRegister = true:$haveRegister = false;

//返回用户ID
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