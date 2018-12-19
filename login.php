<?php
header('Content-Type:application/json; charset=utf-8;');

@$userOpenID = $_GET['userOpenID'];
@$userNickName = $_GET['userNickName'];
@$useServer = $_GET['useServer'];
$data = NULL;
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
    $userEmail=$take['userEmail'];
    $userID=$take['userID'];
    if (!strcmp($userNickName,$take['userNickName']))
    {
        $sql="update tb_user set userNickName='".$userNickName."' where userID=$userID";
        mysql_query($sql,$myLink);
    }
    $data['userEmail'] = $userEmail;
    $data['userID'] = intVal($userID);
}
else{
    $haveRegister=false;
}
mysql_free_result($result);

header('Content-Type:application/json; charset=utf-8;');
$data['haveRegister']=$haveRegister;
echo json_encode($data);


?>