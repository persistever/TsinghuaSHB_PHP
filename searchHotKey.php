<?php
header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];

/*
 *@php 获取搜索热词
 *@$_GET 接收的数据
 *@var array $data 回传的数据，返回搜索热词列表
 */
$data=array();

//连接和选择数据库
header('Content-Type:text/html charset=utf-8;');

if($useServer){
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
    
}
else{
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}

mysql_select_db("db_try1",$myLink);

//从热词列表中按照搜索次数查询前六条记录
$sql="select * from tb_searchhot order by searchHotKeyNO DESC LIMIT 6";
$result = mysql_query($sql, $myLink);

while($take = mysql_fetch_array($result)){
    $tempData=$take['searchHotKeyName'];
    array_push($data,$tempData);
}

mysql_free_result($result);
header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);

?>