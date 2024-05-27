const express = require('express');
const app = express();
const httpServer = require('http').createServer(app);
const io = require('socket.io')(httpServer, {
    cors: {
        origin: '*',
    }
});

app.use(express.static('public'));


io.on('connect' , (socket) => {
    console.log('connected', socket.id);

    socket.on('draw', (data) => {
        socket.broadcast.emit('onDraw', data);
    });
    
    socket.on('clear' , () => {
        socket.broadcast.emit('onClear');
    });

    socket.on('disconnect', () => {
        console.log('disconnected', socket.id);
    });
});





const PORT = process.env.PORT || 3009 ;
httpServer.listen(PORT, () => {
    console.log(`server is running on port ${PORT}`);
});