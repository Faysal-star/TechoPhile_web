const path = require('path');
const express = require('express');
const http = require('http');
const socketio = require('socket.io');
const mysql = require('mysql');
const multer = require('multer');
const fs = require('fs');
const app = express();
const server = http.createServer(app);
// const io = socketio(server);
const io = socketio(server, {
    cors: {
      origin: "*",
      methods: ["GET", "POST"] 
    }
});
const formatMessage = require('./utils/messages');
const {userJoin, getCurrentUser, userLeave, getRoomUsers} = require('./utils/users');
const {encryptMessage, decryptMessage} = require('./utils/secure');

// app.use(express.static(path.join(__dirname, 'public')))

const storage = multer.diskStorage({
    destination: (req, file, cb) => {
      cb(null, 'img/');
    },
    filename: (req, file, cb) => {
      cb(null, Date.now() + path.extname(file.originalname));
    }
});

const upload = multer({ storage: storage });

app.use('/img', express.static(path.join(__dirname, 'img')));


app.post('/uploadImg', upload.single('image'), (req, res) => {
    if (!req.file) {
      return res.status(400).send('No file uploaded.');
    }
    const imageUrl = `${req.protocol}://${req.get('host')}/img/${req.file.filename}`;
    res.send({ imageUrl: imageUrl });
});





// setup mysql
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'techo_web',
    port: 3306
});

db.connect((err) => {
    if(err){
        throw err;
    }
    console.log('Connected to database');
    db.query('CREATE TABLE IF NOT EXISTS msg(id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(255), msg VARCHAR(255), time VARCHAR(255), room VARCHAR(255))', (err, result) => {
        if(err){
            throw err;
        }
        console.log('Table created');
    })
});

// Run when client connects
io.on('connection', socket => {
    // console.log("hola");
    socket.on('joinRoom', ({ username, room }) => {
        
        const user = userJoin(socket.id, username, room);
        socket.join(user.room) ;
        
        // console.log(username, room);
        socket.emit('message', formatMessage('Bot' ,'Welcome to TechoChat'));

        socket.broadcast
        .to(user.room)
        .emit(
            'message', 
            formatMessage('Bot',`${user.username} has joined the chat`)
        );

        io.to(user.room).emit('roomUsers', {
            room: user.room,
            users: getRoomUsers(user.room)
        });

        db.query('SELECT * FROM msg', (err, result) => {
            if(err){
                throw err;
            }
            result.forEach((msg) => {
                const decryptedMsg = decryptMessage(msg.msg);
                if(user.room == msg.room) socket.emit('message', formatMessage(msg.username, decryptedMsg, msg.time));
            });
        });
       
    });

    

    // Listen for chatMessage
    socket.on('chatMessage', (msg) => {
        const user = getCurrentUser(socket.id);
        io.to(user.room).emit('message', formatMessage(user.username,msg));

        // save to database
        const encryptedMsg = encryptMessage(msg);

        db.query('INSERT INTO msg(username, msg, time, room) VALUES(?, ?, ?, ?)', [user.username, encryptedMsg, formatMessage(user.username, msg).time, user.room], (err, result) => {
            if(err){
                throw err;
            }
            console.log('Message saved');
        });
    });

    socket.on('botMessage', (msg) => {
        const user = getCurrentUser(socket.id);
        io.to(user.room).emit('message', formatMessage('Bot',msg));
        db.query('INSERT INTO msg(username, msg, time, room) VALUES(?, ?, ?, ?)', ['Bot', msg, formatMessage('Bot', msg).time, user.room], (err, result) => {
            if(err){
                throw err;
            }
            console.log('Message saved');
        });
    });

     // Runs when client disconnects
     socket.on('disconnect', () => {
        const user = userLeave(socket.id);

        if(user){
            io.to(user.room).emit('message', formatMessage('Bot',`${user.username} has left the chat`));
            io.to(user.room).emit('roomUsers', {
                room: user.room,
                users: getRoomUsers(user.room)
            });
        }
    });

})

const PORT = process.env.PORT || 3000;
server.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT} `);
});