<?php


require_once  __DIR__ . '/vendor/autoload.php' ;
use  PhpAmqpLib\Connection\AMQPStreamConnection ;
use  PhpAmqpLib\Message\AMQPMessage ;

$connection = new AMQPStreamConnection ( 'localhost' , 5672 , 'mehdi' , 'mehdi' );
$channel = $connection->channel();

$channel->queue_declare( 'bonjour' , false , false , false , false );

$msg = new AMQPMessage ( 'Bonjour tout le monde!' );

while(true){
	try{
		$channel->basic_publish ($msg, '' , 'hello' );
		sleep(10);
	}
	catch(Exception $e){
		$e->errorMessage();
	}
}

echo  "[x] Envoyé 'Bonjour tout le monde' \ n" ;

$channel->close();
$connection->close();

?>