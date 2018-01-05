<?php
// $server=new swoole_websocket_server('0.0.0.0',9001);
$server=new \Swoole\Websocket\Server('0.0.0.0',9001);

$server->on('open', function (\Swoole\Websocket\Server $server, $request) {
    echo "server: handshake success with fd{$request->fd}\n";
});

$server->on('message', function (\Swoole\Websocket\Server $server, $frame) {
    echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
    $server->push($frame->fd, "this is server");
});

$server->on('close', function ($ser, $fd) {
    echo "client {$fd} closed\n";
});


$server->on('WorkerStart',function (swoole_server $server, $worker_id)
{
    if (!$serv->taskworker) {
        $server->tick(1024,function($id) use($server){
            foreach($server->connections as $fd)
            {
                $server->push($fd, "当前时间: ".time());
            }
        });
    }
    else
    {
        $serv->addtimer(1000);
    }
});
$server->start();
