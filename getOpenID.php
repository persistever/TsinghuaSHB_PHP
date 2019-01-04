<?php
header('Content-Type:application/json; charset=utf-8;');
@$userCode=$_GET['userCode'];

/*
 *@php 从微信官方url处以code换取加密的OpenID，按照要求这个操作必须又后端服务器发起
 *@$_GET 接收的数据
 *@var array $data 回传的数据，用户的OpenID
 */

include "code.php";

$appid = 'wx64bd3cfc861a6519';
$secret = '3001107d014a9aa432e0b50a2cd6c10a';
$js_code = $userCode;
$grant_type = authorization_code;
$data = array();
$url= 'https://api.weixin.qq.com/sns/jscode2session?'
    .'appid='.$appid    //微信小程序的ID号
    .'&secret='.$secret    //微信小程序的私有密钥
    .'&js_code='.$js_code    //用户的code
    .'&grant_type='.$grant_type;    //授权方式
$result = json_decode(file_get_contents($url),true);

$data['openid'] = $result['openid'];


echo json_encode($data);


?>