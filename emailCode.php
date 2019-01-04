<?php
header('Content-Type:application/json; charset=utf-8;');
@$emailAddress=$_GET['emailAddress'];
@$nickName=$_GET['nickName'];

/*
 *@php 给用户发送验证码
 *@$_GET 接受的数据
 *@var array $data 回传的数据，返回生成的二维码，还有发送是否成功的bool变量
 */
$data=array();

$to = "$emailAddress";    // 邮件接收者
$subject = "清华二手书小程序验证码";    // 邮件标题
$iconURL = "https://tsinghuashb.idlab-tsinghua.com/TsinghuaSHB/Icons/programIcon.png";
$code = str_pad(mt_rand(10,999999),6,"0",STR_PAD_BOTH);

$message = "<h2> 您好! ".$nickName." </h2>";    // 邮件正文
$message .= "<h2> 欢迎您使用清华二手书微信小程序 </h2>";    // 邮件正文
$message .= "<img src=".$iconURL." width=180 height=180>";
$message .= "<h2> 验证码为：<text style='color:#f00'>".$code."</text></h2>";
$message .= "<p>开发团队成员：</p>";
$message .= "<p>贾星衡，韩江玥，郝宇，杨翊蓉，戴圣哲，孙浩博</p>";
$message .= "<a href =http://soft.cs.tsinghua.edu.cn/blog/?q=node/3483 target=_blank >@软件工程2018秋</a>";
$from = "jiaxh17@mails.tsinghua.edu.cn";    // 邮件发送者
$headers = "Content-Type: text/html; charset=utf-8;";
$headers .= "From:" . $from;    // 头部信息设置
$result = mail($to,$subject,$message,$headers);

$data['code']=$code;
$data['result']=$result;
$data['nickName']=$nickName;
echo json_encode($data);

?>