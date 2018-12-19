<?php
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