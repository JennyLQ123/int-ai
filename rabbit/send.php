<?php
	require_once __DIR__ . '/vendor/autoload.php';
    use PhpAmqpLib\Connection\AMQPConnection;
    use PhpAmqpLib\Message\AMQPMessage;
 
    //���������ƺ�routekey
    //$exchange = 'router';
 
    //��������
    $queue = 'modify_rule2';
 
    //����rabbitmq
    $conn = new AMQPConnection('10.112.189.156', '5672', 'admin', 'admin', '/') or die('connect faith');
 
    //����channel  ���������еĲ��������������ִ��
    $ch = $conn->channel();
 
    //���ɶ���
    $ch->queue_declare($queue, false, false, false, false);
 
    //���ɽ�����
    //$ch->exchange_declare($exchange, 'direct', false, true, false);
 
    //�󶨶��м�routekey  routekey��ϵ���������Ƿ��ܽ��ܵ���Ϣ
    //$ch->queue_bind($queue, $exchange);
 
    //������Ϣ
    $msg = new AMQPMessage("" );
 
    //������Ϣ��������
    $ch->basic_publish($msg, '',$queue);//$exchange
 
    //�ر�channel����
    $ch->close();
 
    //�ر�����
    $conn->close();
?>