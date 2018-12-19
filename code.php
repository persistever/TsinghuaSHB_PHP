<?php

function curl_get_https($url)
{
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