<?php
/*
 *@php 用于后台测试能否正常连接数据库，并在tb_stuff表中添加一条测试记录
 */
header('Content-Type:text/html; charset=utf-8;');

$myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
if($myLink){
    echo "connect MySQL succeeded!"."<br>";
}
else{
    echo "connect MySQL failed!"."<br>";
}

mysql_select_db("db_try1",$myLink);
mysql_query("insert into tb_stuff(name,coursename,photopath,price) values('abcde','dfdfd','abcde',10)",$myLink);

?>