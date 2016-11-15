(function (ctx, $){
	var app = {
		conn : new WebSocket('ws://localhost:8080'),
		userList : [],
		init : function(){
			

			this.initChat();
			self.conn.onmessage = function(e) {
				var event =  JSON.parse(e.data);
				if(event.event === 'initUser'){
					var userList = event.value;
					var $user = $('.wc_userList').find('ul');
					var html ="";

					$user.append(html);
					for(var user in userList){
						html+= "<li>"+userList[user].name+"</li>";
						
					}
					$user.find('li').remove();
					$user.append(html);
				}

				if(event.event === 'message'){
					var msg = event.value;
					var $chatScope = $('.wc_chatView');
					var html ="<p>"+msg.name+' say : '+msg.message+"</p>";
					$chatScope.append(html);
				}
				if(event.event === 'retreiveMsg'){

					var msgHistory= JSON.parse(event.value);
					var html ="";
					for(var msg in msgHistory){
						html+="<p>"+ msgHistory[msg].name+' say : '+msgHistory[msg].message+"</p>";
					}
					var $chatScope = $('.wc_chatView');
					$chatScope.find('p').remove();
					$chatScope.append(html);
				}
			};
			this.retreiveMessage();
			this.sendMessage();
		},
		retreiveMessage : function(){
		
			return JSON.stringify({command:'retreiveMsg'});

		
		},
		initUserList : function(){
			var $user = $('.wc_userList').attr('data-curent-user');
			sessionStorage.setItem('userName', $user);
			return JSON.stringify({command:'initUser', value: $user})
		},
		initChat : function(){
			
			
			self.conn.onopen = function(e) {
				// userList.push();
				self.conn.send(self.initUserList());
				self.conn.send(self.retreiveMessage());
				console.log(e)
				console.log("Connection established!");
			};

		},
		sendMessage : function(){
			var $btn = $('.wc_send');
			var userName = sessionStorage.getItem('userName');
			$btn.on('click', function(){
				var $message = self.escapeHtml($('.wc_message').val());
				self.conn.send(JSON.stringify({command:'message', userName: userName, value: $message}));
				
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
