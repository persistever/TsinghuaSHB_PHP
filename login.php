<?php
header('Content-Type:application/json; charset=utf-8;');
@$userOpenID = $_GET['userOpenID'];
@$userNickName = $_GET['userNickName'];
@$useServer = $_GET['useServer'];
@$userIconPath = $_GET['userIconPath'];

/*
 *@php 登陆操作，需要更新用户的微信昵称、微信头像和OpenID信息
 *@$_GET 接收的数据
 *@var array $data 回传的数据，返回haveRegister表示是否在数据库中找到了注册信息
 */

$data = array();
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

//尝试查询用户的注册记录，如果注册过，就更新用户的微信信息，如果没有就把$haveRegister置为false，表示没有注册过
$sql="select * from tb_user where userOpenID='$userOpenID'";
$result = mysql_query($sql,$myLink);
$take = mysql_fetch_array($result);

if($take){
    $haveRegister=true;
    $data['userEmail'] =$take['userEmail'];
    $data['userID'] =intval($take['userID']);
    $data['userIsBlocked']=intval($take['userIsBlocked']);
    $userID = $data['userID'];
    $sql="update tb_user set userNickName= '$userNickName', userIconPath= '$userIconPath' where userID= $userID";
    mysql_query($sql,$myLink);
}
else{
    $haveRegister=false;
}
mysql_free_result($result);

header('Content-Type:application/json; charset=utf-8;');
$data['haveRegister']=$haveRegister;
echo json_encode($data);


?>