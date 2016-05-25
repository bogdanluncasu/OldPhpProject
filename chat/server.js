var express=require("express"),
app=express(),
server=require("http").createServer(app),
io=require("socket.io").listen(server);
nicknames=[];
server.listen(8888);

io.sockets.on('connection',function(socket){
	
	socket.on('send_msg',function(data){
	io.sockets.emit('new_msg',socket.name+" : "+data);
	});
	socket.on('new_user',function(data,callback){
		console.log('wow');
		if(nicknames.indexOf(data)!=-1)callback(false);
		else{
			callback(true);
			socket.name=data;
			nicknames.push(socket.name);
			updateNames();
		}
	});
	function updateNames(){
		io.sockets.emit('usernames',nicknames);
	}
	socket.on('disconnect',function(data){
		var index;
		index = nicknames.indexOf(socket.name);
		nicknames.splice(index, 1);
		updateNames();
	});
	
});	
	
