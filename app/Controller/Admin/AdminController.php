<?php 
namespace App\Controller\Admin;
// use Ratchet\WebSocket\WsServer;
// use Ratchet\Http\Http
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
		add_action('admin_init',array($this,'start'));
		
	}
	public function init(){
		// $page_title, $menu_title, $capability, $menu_slug, $callback_function
		add_menu_page( 'wpChat plugin page', 'wpChat', 'manage_options', '/wpChat/views/admin/dashboard.php', '',plugins_url('/wpChat/public/assets/wpChatIcon.png' ),500 );
	}
	public function start(){
	
		shell_exec('nohup php ../wp-content/plugins/wpChat/server.php > ../wp-content/plugins/wpChat/output.log 2>&1 > ../wp-content/plugins/wpChat/output2.log &');
		$_SESSION['chat']['on'] = true;
		wp_redirect('/wp-admin/admin.php?page=wpChat%2Fviews%2Fadmin%2Fdashboard.php');
		exit();
	}
	public function stop(){
	
		shell_exec("kill $(ps aux | grep '[p]hp' | awk '{print $2}')");
		$_SESSION['chat']['on'] = false;
		wp_redirect('/wp-admin/admin.php?page=wpChat%2Fviews%2Fadmin%2Fdashboard.php');
		exit();
	}



}