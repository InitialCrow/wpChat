<!DOCTYPE html>
<html>
<head>
	<title>dashboard</title>
</head>
<body>
	<h1 class="wcTitle">wpChat</h1>
	<p>manage web socket server and chat option</p>
	<div class="wcWebSock">

	<p>server command : </p>
	<ul>
		<?php if($_SESSION['chat']['on'] === true) {?>
			<p class="wcStatus"> server status : <span class="wcPing wcOn"></span> on line!</p>
			<li><a class="wcOn" href="#">start</a></li>
		<?php } else{ ?>
			<p class="wcStatus"> server status : <span class="wcPing wcOff"></span> off line!</p>
		<li><a href="/wp-admin/index.php/server/start">start</a></li>
		<?php } ?>
		
		<li><a href="/wp-admin/index.php/server/stop">stop</a></li>
	</ul>

	</div>
</body>
</html>