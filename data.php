<?php
header('Content-Type:application/json; charset=utf-8;');
$data = array('netTestValue'=>'网络连接正常，可以发布');
echo json_encode($data);
/*
 *@php 测试前端能够访问后端的脚本，如果可以返回网络连接正常，可以发布
 */
?>