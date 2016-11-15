<?php

/**
* 
*/
namespace App\Controller;
// use Ratchet\WebSocket\WsServer;
// use Ratchet\Http\HttpServer;
// use Ratchet\Server\IoServer;
// use App\Chat;

require __DIR__.'/../../../../../wp-includes/pluggable.php';
require __DIR__ .'../../../vendor/autoload.php';

class ChatController
{
	
	public function init(){
		var_dump($_SESSION['chat']);
		if(!empty($_SESSION['chat'])){
			
			include_once __DIR__."/../../views/chat.php";
		}
		else{

			include_once __DIR__."/../../views/login.php";
		}
	}
	public function login(){
		$name = strip_tags($_POST['login']);
		$_SESSION['chat']['name'] = $name;
		wp_redirect('/');
		exit();
	}

}