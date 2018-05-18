<?php

require_once  __DIR__ . '/vendor/autoload.php' ;
use  PhpAmqpLib\Connection\AMQPStreamConnection ;
use  PhpAmqpLib\Message\AMQPMessage ;

$connection = new AMQPStreamConnection ( 'localhost' , 5672 , 'guest' , 'guest' );
$channel = $connection->channel();

$channel->exchange_declare( 'logs' , 'fanout' , false , false , false );

$data = implode ( '' , array_slice ($argv, 1 ));
if ( empty ($data)) $data = "info: Bonjour tout le monde!" ;
$msg = new AMQPMessage ($data);

while(true){
	try{
		$channel->basic_publish ($msg, 'logs');
		sleep(10);
	}
	catch(Exception $e){
		$e->errorMessage();
	}
}


echo  "[x] Envoyé" , $data, "\ n" ;

$channel->close ();
$connection->close ();

?>