<?php
namespace WebSocket;


class Client extends \Swoole\Client {    
    public function send($data){
        return parent::send(\Swoole\WebSocket\Server::pack($data));
    }

    public function open($host,$port){
        parent::send($this->getHeader($host,$port));
    }

    //TODO 这个host,和port...
    public function getHeader($host,$port){        
        return "GET / HTTP/1.1\r\n".
        "Connection: Upgrade\r\n".
        "Host: $host: $port\r\n".
        "Origin: null\r\n".
        "Sec-WebSocket-Extensions: x-webkit-deflate-frame\r\n".
        "Sec-WebSocket-Key: puVOuWb7rel6z2AVZBKnfw==\r\n".
        "Sec-WebSocket-Version: 13\r\n".
        "Upgrade: websocket\r\n\r\n";
    }
}

//TEST
$client=new \WebSocket\Client(SWOOLE_SOCK_TCP,SWOOLE_SOCK_ASYNC);
$client->on("connect", function(\Swoole\Client $cli) {
    echo "connect\n";
    $cli->open('swserv',9001);
    $cli->send('hello');
});
$client->on("receive", function(\Swoole\Client $cli, $data){
    echo "Receive: $data";
});
$client->on("error", function(\Swoole\Client $cli){
    echo "error\n";
});
$client->on("close", function(\Swoole\Client $cli){
    echo "Connection close\n";
});
$client->connect('swserv', 9001);

//SYNC
$client=new \WebSocket\Client(SWOOLE_SOCK_TCP);
$client->connect();
$client->open();
$client->send('hello');
echo $client->recv();