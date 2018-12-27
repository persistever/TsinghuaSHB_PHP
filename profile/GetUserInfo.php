<?php

header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];
@$userID=intval($_GET['userID']);

include "../ConnectDataBase.php";

$data = array();

$myLink = ConnectDataBase($useServer);
header('Content-Type:text/html charset=utf-8;');

mysql_select_db("db_try1",$myLink);

$sql = "select * from tb_user where userID=$userID";
$result = mysql_query($sql,$myLink);
$take = mysql_fetch_array($result);

$data['userGrade'] = $take['userGrade'];

mysql_free_result($result);

header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);



?>