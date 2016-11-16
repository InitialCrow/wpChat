<?php 
namespace App\Controller\Admin;
// use Ratchet\WebSocket\WsServer;
// use Ratchet\Http\Httphoudan1996
// use Ratchet\Server\IoServer;
// use App\Chat;

$path = $_SERVER['DOCUMENT_ROOT'];


include_once $path . '/wp-admin/includes/plugin.php';
include_once $path . '/wp-includes/pluggable.php';
require __DIR__ .'../../../../vendor/autoload.php';

class AdminController
{
	public function __construct(){
		add_action('admin_menu',array($this,'init'));
		
	}
	public function init(){
		// $page_title, $menu_title, $capability, $menu_slug, $callback_function
		add_menu_page( 'wpChat plugin page', 'wpChat', 'manage_options', 'set wpChat', '',plugins_url('/wpChat/public/assets/wpChatIcon.png' ),500 );
	}



}