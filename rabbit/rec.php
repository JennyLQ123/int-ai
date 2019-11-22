<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPConnection;
//binding_key 关系到是否能够获取对象消息
$binding_key = 'web2';

//队列名称
$queue_name ='web2' ;//'push_queue'

//链接rabbitmq
$conn = new AMQPConnection('10.112.189.156', '5672','admin', 'admin') or die("connect faith");

//生成channel对象 也可使用$conn->channel()方法生成
$ch = new \PhpAmqpLib\Channel\AMQPChannel($conn);

//生成队列
$ch->queue_declare($queue_name, false, true, false, false);//third 持久化

//绑定队列和binding_key
//$ch->queue_bind($queue_name, $binding_key);

// echo 'To exit press Ctrl + C', "\n";

//回调函数,使用回调函数输出获取的消息
$cb = function($msg) {
    echo $msg->body, "\n";
};
//获取队列中信息及绑定回调函数
//$ch->basic_consume($queue_name, '', false, true, false, false, $cb);//fourh
$mess = $ch->basic_get($queue_name);
echo $mess->body;
$ch->basic_ack($mess->delivery_info["delivery_tag"]);//
/*
while (count($ch->callbacks)) {
    echo $flag;
    if($flag){
    $ch->wait();
    }else{
        $ch->close();
        $conn->close();
        return;
        break;
    }
}
*/



$ch->close();
$conn->close();
//echo '1';
?>