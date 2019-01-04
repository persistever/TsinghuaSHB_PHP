<?php
header('Content-Type:application/json; charset=utf-8;');
@$name = $_POST['subject'];
@$price = $_POST['price'];
@$courseName = $_POST['courseName'];
@$useServer = $_POST['useServer'];
@$date=date("Y-m-d-H-i-s");

/*
 *@php 上传单张照片
 *@$_GET 接收的数据
 */

//根据是否使用后端服务器还是用本地伪服务器选择图片保存的位置
if($useServer){
    $dataBasePath = "C:\HwsNginxMaster\wwwroot\TsinghuaSHB\Pictures\\";
}
else{
    $dataBasePath = "D:\Project\PHP\TsinghuaSHB\Pictures\\";
}
//保存图片
@$fileName = "_UEMAIL_".$_POST['email']."_TIME_$date".'.jpg';
$path = $dataBasePath.$fileName;
if(move_uploaded_file($_FILES['file']['tmp_name'], $path)){
    echo 'upload succeeded!';
}
else{
    echo 'upload failed';
}
//将图片地址保存到数据库中
header('Content-Type:text/html; charset=utf-8;');
if($useServer){
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}
else{
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}

mysql_select_db("db_try1",$myLink);
mysql_query("insert into tb_stuff(name,coursename,photopath,price) values('$name','$courseName','$fileName',$price)",$myLink);

?>