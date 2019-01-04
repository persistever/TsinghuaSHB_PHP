<?php

/*
 *@php 连接数据库的公用脚本
 */
function ConnectDataBase($useServer){

    if($useServer){
        $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
        
    }
    else{
        $myLink = mysql_pconnect("localhost","root","TsinghuaSHB")or die("failed".mysql_error());
    }
    
    return $myLink;
}
?>