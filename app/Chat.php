<?php
namespace App;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use App\ChatController;
use StdClass;

class Chat implements MessageComponentInterface {
    protected $clients;
    private $userList = [];

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";

    }

    public function onMessage(ConnectionInterface $from, $msg) {
	$numRecv = count($this->clients) - 1;
	echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
	, $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

	$msg = json_decode($msg);

	if($msg->command === 'initUser'){
		$credential = new StdClass();
		if(!empty($msg->value)){

			$credential->name =  $msg->value;
			$credential->id = $from->resourceId;
			echo $credential->name." -> join chat";
			array_push($this->userList, $credential);
		}
		foreach ($this->clients as $client) {

			// The sender is not the receiver, send to each client connected
			$client->send(json_encode(array('event'=>'initUser', 'value'=>$this->userList)));
		}
	}
	if($msg->command === 'message'){
		$user= [];
		$user['name'] = $msg->userName;
		$user['message'] = $msg->value;

		$user = json_encode($user);

		$file = 'app/history.json';
		$current = file_get_contents($file);
		$current .= $user;
		file_put_contents($file, $current);
		foreach ($this->clients as $client) {

			// The sender is not the receiver, send to each client connected
			
			$client->send(json_encode(array('event'=>'message', 'value'=> array('name' =>$msg->userName , 'message'=>$msg->value ))));
		}
	}
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        for($i=0; $i<count($this->userList);$i++){
        	if($this->userList[$i]->id == $conn->resourceId){
        		array_splice($this->userList, $i,1);
        		
        	}
        }


        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
