<?php
//header('Content-Type:application/json; charset=utf-8;');

/*
 *@php 起初尝试用socket技术实现聊天功能，后期因为服务器wss服务配置问题未能实现
 */

set_time_limit(0);

$host = "0.0.0.0";
$port = 38383;

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)
    or die("socket_create() failed:". socket_strerror(socket_last_error()));

//设置阻塞模式
socket_set_block($socket)
    or die("socket_set_block() failed:". socket_strerror(socket_last_error()));

// 绑定到端口
socket_bind($socket, $host, $port)
    or die("socket_bind() failed:" . socket_strerror(socket_last_error()));

// 开始监听
socket_listen($socket, 4)
    or die("socket_listen() failed:" . socket_strerror(socket_last_error()));

echo iconv('utf-8','gb2312',"Binding the socket on $host:$port ... \n");

while (true) {
    // 接收连接请求并调用一个子连接Socket来处理客户端和服务器间的信息
    if (($msgsock = socket_accept($socket)) < 0) {
        echo "socket_accept() failed:" . socket_strerror(socket_last_error());
    } else {
        // 读数据
        $out = '';
        while ($buf = socket_read($msgsock, 1024)) {  #注意 主要是这里 这里用的是默认的 type 这里要读取1024字节 如果客户端没有发送这么多数据就会造成子连接的阻塞 导致程序无法继续向下执行 所以要执行一些判断
            if (!$buf) {
                break;
            }
            $out .= $buf;
            if (trim($buf) == "Shut") {
                break;
            }
            if (substr($buf, -1) == "\n") { #这里注意 “\n”换行符是一个字节长度
                break;
            }
        }

        // 写数据
        $in = "接收的数据是 $out";
        echo iconv('utf-8','gb2312',$in);
		$out = "你好，消息来自主机，机器是戴尔台式机";
        if (!socket_write($msgsock, $out, strlen($out))) echo "socket_write() failed:" . socket_strerror($socket);
    }
    // 结束通信
    socket_close($msgsock);
}
socket_close($socket);

?>