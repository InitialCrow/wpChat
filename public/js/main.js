(function (ctx, $){
	var app = {
		conn : new WebSocket('ws://localhost:8080'),
		userList : [],
		init : function(){
			

			this.initUserlist();
			self.conn.onmessage = function(e) {
				console.log(e.data);
			};
			this.sendMessage();
		},
		initUserlist : function(){
			var $user = $('.userList').attr('data-curent-user');
			
			self.conn.onopen = function(e) {
				// userList.push();
				self.conn.send(JSON.stringify({command:'initUser', value: $user}));
				console.log(e)
				console.log("Connection established!");
			};

		},
		sendMessage : function(){
			var $message = $('.wc_message').val();
			var $btn = $('.wc_send');

			$btn.on('click', function(){
				console.log($message);

				$message = self.escapeHtml($message);
				self.conn.send($message);
			});
			
		},
		escapeHtml: function(text){
			var map = {
			'&': '&amp;',
			'<': '&lt;',
			'>': '&gt;',
			'"': '&quot;',
			"'": '&#039;'
			}

			return text.replace(/[&<>"']/g, function(m) { return map[m]; });
		},
	}
	ctx.app = app;
	var self = app;
})(window, jQuery)
