<?php

namespace app\rabbitPHP;

require_once  __DIR__ . '/vendor/autoload.php' ;
utilisez  PhpAmqpLib\Connection\ AMQPStreamConnection ;
utilisez  PhpAmqpLib\Message\ AMQPMessage ;

$connection = new AMQPStreamConnection ( 'localhost' , 5672 , 'guest' , 'guest' );
$channel = $connection->channel();

$channel->queue_declare( 'bonjour' , false , false , false , false );

$msg = new AMQPMessage ( 'Bonjour tout le monde!' );
$channel->basic_publish ($msg, '' , 'hello' );

echo  "[x] Envoyé 'Hello World!' \ n" ;

$channel->close ();
$connection->close ();

?>