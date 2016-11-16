<?php
/**
* Plugin Name: wpChat
* Plugin URI: http://dev.wp-cours.com/
* Description: plugin for website anouncing maintenace
* Version: 1.0 or whatever version of the plugin (pretty self explanatory)
* Author: Adam Parent (InitialCrow)
* Author URI: http://adam-parent.com
* License: MIT
*/
require __DIR__ .'/vendor/autoload.php';
use App\Controller\ChatController;
use App\EzRouter;

session_start();



function wpChat_scripts() {
    wp_enqueue_style( 'wpChat', plugins_url('wpChat/public/css/chat.css' ) );
    wp_enqueue_style( 'wpChatLogin', plugins_url('wpChat/public/css/login.css' ) );
    wp_enqueue_script( 'main', plugins_url('wpChat/public/js/main.js' ),array( 'jquery' ), false, false );
}

function wpChat_init(){
	include_once __DIR__."/views/partial/script.php";
	
}



function wpChat_route(){
	$router = new EzRouter();
		$router->route('/',[ChatController::class, 'init']);
		$router->route('/index.php/login',[ChatController::class,'login']);
		$router->route('/index.php/wc_unlog',[ChatController::class,'disconect']);
	$router->end();
}
add_action('init', 'wpChat_route' );
add_action('wp_footer','wpChat_init');
add_action('wp_enqueue_scripts', 'wpChat_scripts' );



