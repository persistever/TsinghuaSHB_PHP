<?php
header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];
@$itemID=intval($_GET['itemID']);
@$userID=intval($_GET['userID']);
@$status=intval($_GET['status']);

/*
 *@php 删除用户的某条发布上传记录
 *@$_GET 接受的数据
 *@var array $data 回传的数据，返回状态信息
 */

include "ConnectDataBase.php";
$data = array();

//连接和选择数据库
$myLink = ConnectDataBase($useServer);
header('Content-Type:text/html charset=utf-8;');
mysql_select_db("db_try1",$myLink);

//根据接收到的前端的status判断该进行什么操作
switch($status){
    //status==-1，重新恢复发布
    case -1:
        $sql = "update tb_trade set itemIsPublished=1 where userID=$userID AND itemID=$itemID";
        $result = mysql_query($sql,$myLink);
        break;
    //status==0，删除该条发布记录
    case 0:
        $sql = "update tb_trade set itemIsDelete=1 where userID=$userID AND itemID=$itemID";
        $result = mysql_query($sql,$myLink);
        break;
    //status==1，隐藏该发布记录
    case 1:
        $sql = "update tb_trade set itemIsPublished=0 where userID=$userID AND itemID=$itemID";
        $result = mysql_query($sql,$myLink);
        break;
    //其他状态返回错误
    default:
        $data['error'] = 'input error';
        break;        
}

//成功的话mysql_query会返回true的bool变量，否则为false
if($result){
    $data['status'] = 'success';
}else{
    $data['status'] = 'fail';
}

header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);

?>