<?php
header('Content-Type:application/json; charset=utf-8;');
$data = array('netTestValue'=>'后台访问正常');
echo json_encode($data);
?>