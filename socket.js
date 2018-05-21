const app   = require('express')();
const http  = require('http').Server(app);
const io    = require('socket.io')(http);
const redis = require('ioredis')();
const err   = function(err, count) {};

redis.subscribe('test-channel',err);
redis.subscribe('chat',err);

redis.on('message', function(channel, message) {
    console.log('Message Recieved: ' + message);
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});

http.listen(3000, function(){
    console.log('Listening on Port 3000');
});