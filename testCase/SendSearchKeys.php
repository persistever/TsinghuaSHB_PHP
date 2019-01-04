<?php
/*
 *@php 用户搜索测试用例模拟去前端发送关键字
 *@var $myFileSend 发送包含关键字的文本
 *@var $myFileReceive 接收的搜索结果保存的文本
 */

$myFileSend = fopen("searchKeys.txt", "r") or die("Unable to open file!");
$myFileReceive = fopen("searchResult.txt","w") or die("Unable to open file!");
$j=1;
while(!feof($myFileSend)) {
    $searchInput= fgets($myFileSend);
    if(strlen($searchInput)==0) break;
    header('Content-Type:application/json; charset=utf-8;');
    //调用后端search.php脚本进行搜索
    $url = 'https://tsinghuashb.idlab-tsinghua.com/TsinghuaSHB/search.php?useServer=1&searchInput='.$searchInput;
    $result = json_decode(file_get_contents($url));
    fwrite($myFileReceive,$j." 搜索：".$searchInput);
    for($i=0;$i<count($result);$i++){
        //result是一个标准Object列表，需要用->符号访问每个Object的元素
        fwrite($myFileReceive,$result[$i]->itemName."\n");
    }
    fwrite($myFileReceive,"\n");
    $j++;
}
header('Content-Type:text/html; charset=utf-8;');
//返回"测试完成"提示
echo "测试完成";
fclose($myFileSend);
fclose($myFileReceive);


?>