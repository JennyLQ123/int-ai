<?php
	require_once __DIR__ . '/vendor/autoload.php';
    use PhpAmqpLib\Connection\AMQPConnection;
    use PhpAmqpLib\Message\AMQPMessage;
 
    //交换器名称和routekey
    //$exchange = 'router';
 
    //队列名称
    $queue = 'modify_rule2';
 
    //链接rabbitmq
    $conn = new AMQPConnection('10.112.189.156', '5672', 'admin', 'admin', '/') or die('connect faith');
 
    //生成channel  基本上所有的操作都由这个对象执行
    $ch = $conn->channel();
 
    //生成队列
    $ch->queue_declare($queue, false, false, false, false);
 
    //生成交换器
    //$ch->exchange_declare($exchange, 'direct', false, true, false);
 
    //绑定队列及routekey  routekey关系到消费器是否能接受到消息
    //$ch->queue_bind($queue, $exchange);
 
    //生成信息
    $msg = new AMQPMessage("" );
 
    //发送信息到交换器
    $ch->basic_publish($msg, '',$queue);//$exchange
 
    //关闭channel链接
    $ch->close();
 
    //关闭链接
    $conn->close();
?>