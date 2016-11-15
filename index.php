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

$router = new EzRouter();

function wpChat_scripts() {
    wp_enqueue_style( 'wpChat', plugins_url('wpChat/public/css/chat.css' ) );
    wp_enqueue_style( 'wpChatLogin', plugins_url('wpChat/public/css/login.css' ) );
    wp_enqueue_script( 'main', plugins_url('wpChat/public/js/main.js' ),array( 'jquery' ), false, true );
}

function wpChat_init(){
	include_once __DIR__."/views/partial/script.php";
	
}
$router->route('/index.php/login',[ChatController::class,'login']);

$router->end();
function wpChat_chatView(){
	ChatController::init();
}

add_filter('the_content', 'wpChat_chatview' );
add_action('shutdown','wpChat_init');
add_action('wp_enqueue_scripts', 'wpChat_scripts' );



