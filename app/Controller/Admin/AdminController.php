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
		$pid = shell_exec('pidof php');
		if(!empty($pid)){
			$_SESSION['chatServer']['on'] = true;
		}
		else{
			$_SESSION['chatServer']['on']= false;
		}
	}
	public function start(){
	
		shell_exec('nohup php ../wp-content/plugins/wpChat/server.php > ../wp-content/plugins/wpChat/output.log 2>&1 > ../wp-content/plugins/wpChat/output2.log &');
		$_SESSION['chatServer']['on'] = true;
		wp_redirect('/wp-admin/admin.php?page=wpChat%2Fviews%2Fadmin%2Fdashboard.php');
		exit();
	}
	public function stop(){
		
		shell_exec("kill $(ps aux | grep '[p]hp' | awk '{print $2}')");
		$_SESSION['chatServer']['on'] = false;
		unset($_SESSION['chatServer']['logs']);
		wp_redirect('/wp-admin/admin.php?page=wpChat%2Fviews%2Fadmin%2Fdashboard.php');
		exit();
	}
	public function restart(){
		shell_exec("kill $(ps aux | grep '[p]hp' | awk '{print $2}')");
		shell_exec("nohup php ../wp-content/plugins/wpChat/server.php > ../wp-content/plugins/wpChat/output.log 2>&1 > ../wp-content/plugins/wpChat/output2.log & ");

		$_SESSION['chatServer']['on'] =true;
		$_SESSION['chatServer']['logs'] = "server restarted";
		wp_redirect('/wp-admin/admin.php?page=wpChat%2Fviews%2Fadmin%2Fdashboard.php');
		exit();
	}
	public function clearHistory(){
		$file = __DIR__.'/../../history.json';
		file_put_contents("$file", "");
		wp_redirect('/wp-admin/admin.php?page=wpChat%2Fviews%2Fadmin%2Fdashboard.php');
		exit();
	}



}