<?php
/*
 *@php 访问其他https网站获取数据的脚本
 */
function curl_get_https($url)
{
    header('Content-Type:application/json; charset=utf-8;');
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);  // 跳过检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  // 跳过检查
    $tmpInfo = curl_exec($curl);
    curl_close($curl);
    return $tmpInfo;   //返回json对象
}

?>