<?php
header('Content-Type:application/json; charset=utf-8;');

@$useServer = $_POST['useServer'];
@$num = $_POST['num'];
@$itemPublishTime = date("Y-m-d-H-i-s");
$data = NULL;

if($useServer){
    $dataBasePath = "C:\HwsNginxMaster\wwwroot\TsinghuaSHB\Pictures\\";
}
else{
    $dataBasePath = "D:\Project\PHP\TsinghuaSHB\Pictures\\";
}
$fileType = end(explode(".",$_FILES['file']['name']));
$path = $dataBasePath."_TIME_".$itemPublishTime.'_'.$num.'.'.$fileType;
if(move_uploaded_file($_FILES['file']['tmp_name'], $path)){
    $data['path']= $path;
    $data['status'] = 'upload success';
}
else{
    $data['path']= $path;
    $data['status'] = 'upload failed';
}

echo json_encode($data);

?>