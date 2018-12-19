<?php
header('Content-Type:application/json; charset=utf-8;');
$totalIndex=$_GET['totalIndex'];
$useServer=$_GET['useServer'];
$serverURL=$_GET['serverURL'];
$data = array(Null);
for($i=0;$i<$totalIndex;$i++){
    $data[$i]=NULL;
}

header('Content-Type:text/html charset=utf-8;');

if($useServer){
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
    
}
else{
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}

$serverPath=$serverURL.'Pictures/';
mysql_select_db("db_try1",$myLink);
$info = mysql_query("select * from tb_stuff");

for($i=0;$i<$totalIndex;$i++){
    $j=0;
    while($take = mysql_fetch_array($info)){
        $data[$i][$j]['subject']=$take['name'];
        $data[$i][$j]['coverPath']=$serverPath.$take['photopath'];
        $data[$i][$j]['price']=$take['price'];
        $data[$i][$j]['courseName']=$take['coursename'];
        $data[$i][$j]['id']=$j+1;
        $j++;
    }
}

mysql_free_result($info);

echo json_encode($data);

?>