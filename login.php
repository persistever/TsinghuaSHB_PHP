<?php
header('Content-Type:application/json; charset=utf-8;');

@$userOpenID = $_GET['userOpenID'];
@$userNickName = $_GET['userNickName'];
@$useServer = $_GET['useServer'];
@$userIconPath = $_GET['userIconPath'];

$data = array();
$haveRegister = NULL;

header('Content-Type:text/html charset=utf-8;');
if($useServer){
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}
else{
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}

mysql_select_db("db_try1",$myLink);

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