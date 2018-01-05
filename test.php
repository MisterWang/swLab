<?php
//创建Server对象，监听 127.0.0.1:9501端口
// $serv = new swoole_server("127.0.0.1", 9001); 
$serv = new swoole_server("0.0.0.0", 9001); 

$serv->on('connect', function ($serv, $fd) {  
    echo "Client: Connect.\n";
});
//监听数据发送事件
$serv->on('receive', function ($serv, $fd, $from_id, $data){
//    $serv->send($fd, "Server: ".$data);
    // $serv->task($data);
    echo $data;
    echo "test\n";
    $serv->send($fd,"123\n");
});
//监听连接关闭事件
$serv->on('close', function ($serv, $fd) {
    echo "Client: Close.\n";
});
//workstart
$serv->on('workerStart',function($serv,$worker_id){
    echo "workerstart\n";
});
//task
$serv->on('task',function($serv,$task_id,$from_id,$data){
});
//task finished
$serv->on('finish',function($serv,$task_id,$data){
});
$serv->on('shutdown',function($serv){
    echo "shutdown\n";
});
$serv->set(array(
    // 'task_worker_num'=>2,
    // 'woker_num'=>3,
    'package_max_length' => 8192,
    'open_eof_check'=> true,
    'package_eof' => "\r\n",
    // 'daemonize'=>1,
    // 'log_file'=>'a.log'
));

//启动服务器
$serv->start(); 