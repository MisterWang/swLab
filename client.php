<?php
$client = new swoole_client(SWOOLE_SOCK_TCP);
// if (!$client->connect('192.168.99.100', 9000, 10))
// if (!$client->connect('127.0.0.1', 9000, 10))
if (!$client->connect('swserv',9001, 10))
//if (!$client->connect('sw',9000, 10))
{
    exit("connect failed. Error: {$client->errCode}\n");
}
var_dump($client);
$client->send("hello world\r\n");
echo $client->recv();
$client->close();
