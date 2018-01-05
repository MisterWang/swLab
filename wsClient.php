<?php
// $client=new \Swoole\Http\Client('swserv',9001);
$client=new \Swoole\Client(SWOOLE_SOCK_TCP);
$client->connect('swserv',9001);


$header="GET / HTTP/1.1\r\n".
    "Connection: Upgrade\r\n".
    "Host:swserv: 9001\r\n".
    "Origin: null\r\n".
    "Sec-WebSocket-Extensions: x-webkit-deflate-frame\r\n".
    "Sec-WebSocket-Key: puVOuWb7rel6z2AVZBKnfw==\r\n".
    "Sec-WebSocket-Version: 13\r\n".
    "Upgrade: websocket\r\n\r\n";
$client->send($header);
echo $client->recv();

$client->send(\Swoole\WebSocket\Server::pack('hello'));
echo $client->recv();

$client->close();