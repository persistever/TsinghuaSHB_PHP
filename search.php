<?php

header('Content-Type:application/json; charset=utf-8;');
@$useServer=$_GET['useServer'];
@$serverURL=$_GET['serverURL'];
@$searchInput=$_GET['searchInput'];

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
$searchKeys = implode("%' AND $combineSQL like '%",$searchKeys);
$searchKeys= "where ".$combineSQL." like '%".$searchKeys."%'";

// $sql = "select * from db_item where itemSearchString exprep '$searchKeys' order by itemPublishTime";
$sql = "select * from tb_item ".$searchKeys;
//$sql = "select * from tb_item where itemName is '系统学'";
//$sql = "select * from tb_item";


//$data['sql']=$sql;
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
    array_push($data,$tempData);
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

header('Content-Type:application/json; charset=utf-8;');
echo json_encode($data);

?>