<?php
header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];

$data=array();

header('Content-Type:text/html charset=utf-8;');

if($useServer){
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
    
}
else{
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}

mysql_select_db("db_try1",$myLink);

//$sql="select * from tb_searchhot";
$sql="select * from tb_searchhot order by searchHotKeyNO DESC LIMIT 6";
$result = mysql_query($sql, $myLink);
// $take = mysql_fetch_array($result);
// if($take)
// {
//     $data['states']='success';
// }
// else{
//     $data['states']='fail';
// }

while($take = mysql_fetch_array($result)){
    $tempData=$take['searchHotKeyName'];
    array_push($data,$tempData);
}

mysql_free_result($result);
header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);

?>