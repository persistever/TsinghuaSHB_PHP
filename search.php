<?php

header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];
@$serverURL=$_GET['serverURL'];
@$searchInput=$_GET['searchInput'];
@$searchSort=intval($_GET['searchSort']);

$data=array();
$haveSearchResult=0;

$char = "。、！？：；﹑•＂…‘’“”〝〞∕¦‖—　〈〉﹞﹝「」‹›〖〗】【»«』『〕〔》《﹐¸﹕︰﹔！¡？¿﹖﹌﹏﹋＇´ˊˋ―﹫︳︴¯＿￣﹢﹦﹤‐­˜﹟﹩﹠﹪﹡﹨﹍﹉﹎﹊ˇ︵︶︷︸︹︿﹀︺︽︾ˉ﹁﹂﹃﹄︻︼（）";

$pattern = array(
    "/[[:punct:]]/i", //英文标点符号
    '/['.$char.']/u'//中文标点符号
    //'/[ ]{2,}/'  //不消去空格
);

$searchKeys=trim($searchInput," ");  //消除两头的中文空格
$searchKeys=trim($searchInput,' ');  //消除两头的英文空格
$searchKeys = preg_replace($pattern, '', $searchKeys);   //消除中间的无用符号

$searchKeys=split('[  ]',$searchKeys); //按照中英文空格断开
$searchKeys=array_merge(array_diff($searchKeys,[' '," ",''])); //断开之后如果还有空格，消去，也消去空字符
$searchKeysBackup = $searchKeys;

//$data['searchkeys']=$searchKeys;

header('Content-Type:text/html charset=utf-8;');

if($useServer){
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
    
}
else{
    $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
}

mysql_select_db("db_try1",$myLink);


$combineSQL="CONCAT(itemName,itemSort,itemCourseName,itemCourseNO,itemCourseTeacher)";
$searchKeys = implode("%' AND $combineSQL like '%",$searchKeys);  //将数组元素合成字符串
$searchKeys= "where ".$combineSQL." like '%".$searchKeys."%'";  //拼接搜索条件

$searchOrder="";
switch($searchSort){
    case 0:
        $searchOrder=" order by itemPublishTime DESC";
        break;
    case 1:
        $searchOrder=" order by itemPublishTime ASC";
        break;
    case 2:
        $searchOrder=" order by itemPrice ASC";
        break;
    case 3:
        $searchOrder=" order by itemPrice DESC";
        break;
    default:
        $searchOrder=" order by itemPublishTime DESC";
        break;
}
$sql = "select * from tb_item ".$searchKeys.$searchOrder;
$result = mysql_query($sql, $myLink);

// if($take){
//     $data['search status']=true;
// }
// else{
//     $data['search status']=false;
// }


$serverPath=$serverURL.'Pictures/';

while($take = mysql_fetch_array($result)){
    $haveSearchResult=1;
    $tempData=array();
    $tempData['itemName']=$take['itemName'];
    $tempData['itemCoverPath']=$serverPath.$take['itemPicturePath0'];
    $tempData['itemPrice']=$take['itemPrice'];
    $tempData['itemShortInfo']=$take['itemShortInfo'];
    $tempData['itemID']=$take['itemID'];
    
    $tempItemID = intval($take['itemID']);
    $sql = "select * from tb_trade where itemID=$tempItemID";
    $result1 = mysql_query($sql,$myLink);
    $take1 = mysql_fetch_array($result1);
    if(intval($take1['itemIsSold'])==0 && intval($take1['itemIsPublished'])==1 &&  intval($take1['itemIsDelete'])==0){
        array_push($data,$tempData);
    }
    mysql_free_result($result1);
}

mysql_free_result($result);

if($haveSearchResult){
    foreach($searchKeysBackup as $tempKey){
        $sql = "select * from tb_searchhot where searchHotKeyName='$tempKey'";
        $result = mysql_query($sql, $myLink);
        $take = mysql_fetch_array($result);
        if($take){
            $num = $take['searchHotKeyNO']+1;
            $sql = "update tb_searchhot set searchHotKeyNO=$num where searchHotKeyName='$tempKey'";
            mysql_query($sql, $myLink);
        }
        else{
            $num = 1;
            $sql = "insert into tb_searchhot(searchHotKeyName,searchHotKeyNO) values('$tempKey',$num)";
            mysql_query($sql, $myLink);
        }
    }
}

mysql_free_result($result);
header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);

?>