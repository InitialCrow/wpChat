<?php

/**
* 
*/
namespace App\Controller;


class ChatController
{
	
	public function init(){
	
		if(!empty($_SESSION['chat'])){
			
			include_once plugin_dir_path(__FILE__)."/../../views/chat.php";
		}
		else{

			include_once plugin_dir_path(__FILE__)."/../../views/login.php";
		}
	}
	public function login(){
		$name = strip_tags($_POST['login']);
		$_SESSION['chat']['name'] = $name;
		wp_redirect('/');
		exit();
	}
	public function disconect(){
		unset($_SESSION['chat']['name']);
		wp_redirect('/');
		exit();
	}


}