<?php

$myFileSend = fopen("searchKeys.txt", "r") or die("Unable to open file!");
$myFileReceive = fopen("searchResult.txt","w") or die("Unable to open file!");
$j=1;
while(!feof($myFileSend)) {
    $searchInput= fgets($myFileSend);
    if(strlen($searchInput)==0) break;
    header('Content-Type:application/json; charset=utf-8;');
    $url = 'https://tsinghuashb.idlab-tsinghua.com/TsinghuaSHB/search.php?useServer=1&searchInput='.$searchInput;
    $result = json_decode(file_get_contents($url));
    fwrite($myFileReceive,$j." 搜索：".$searchInput);
    for($i=0;$i<count($result);$i++){
        fwrite($myFileReceive,$result[$i]->itemName."\n");
    }
    fwrite($myFileReceive,"\n");
    $j++;
//     header('Content-Type:text/html; charset=utf-8;');
//     echo "搜索关键字：".$searchInput." 返回结果<br>";
//     print_r($result);
//     echo "<br>";
}
header('Content-Type:text/html; charset=utf-8;');
echo "测试完成";
fclose($myFileSend);
fclose($myFileReceive);


?>