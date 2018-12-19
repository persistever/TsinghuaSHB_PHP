<?php

include "code.php";

header('Content-Type:application/json; charset=utf-8;');

@$userCode=$_GET['userCode'];

//url: 'https://api.weixin.qq.com/sns/jscode2session?'
//'appid=' + 'wx64bd3cfc861a6519' +
//'&secret=' + '3001107d014a9aa432e0b50a2cd6c10a' +
//'&js_code=' + res1.code +
//'&grant_type=authorization_code',
//GET https://api.weixin.qq.com/sns/jscode2session?appid=APPID&secret=SECRET&js_code=JSCODE&grant_type=authorization_code

$appid = 'wx64bd3cfc861a6519';
$secret = '3001107d014a9aa432e0b50a2cd6c10a';
$js_code = $userCode;
$grant_type = authorization_code;
$data = array();
$url= 'https://api.weixin.qq.com/sns/jscode2session?'
    .'appid='.$appid
    .'&secret='.$secret
    .'&js_code='.$js_code
    .'&grant_type='.$grant_type;

// curl方法会直接将下级页面得到的值返回给上级页面，简直不能忍。
// $curl = curl_init();
// curl_setopt($curl, CURLOPT_URL, $url);
// curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 0);
// curl_setopt($curl, CURLOPT_HEADER, 0);
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, 0);
// curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);  // 跳过检查
// curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  // 跳过检查
// $tmpInfo = curl_exec($curl);
// curl_close($curl);

// $result = json_decode($tmpInfo,true);

$result = json_decode(file_get_contents($url),true);

$data['openid'] = $result['openid'];


echo json_encode($data);


?>