<?php
header('Content-Type:application/json; charset=utf-8;');
$data = array('netTestValue'=>'网络连接正常，可以发布');
echo json_encode($data);
?>