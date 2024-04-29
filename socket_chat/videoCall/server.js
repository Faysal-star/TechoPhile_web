const express = require('express')
const app = express()
const server = require('http').Server(app)
const io = require('socket.io')(server)
const { v4: uuidV4 } = require('uuid')
const {userJoin, getCurrentUser, userLeave, getRoomUsers} = require('./utils/user');

app.set('view engine', 'ejs')
app.use(express.static('public'))

app.get('/vid', (req, res) => {
    const roomID = uuidV4();
    const userName = req.query.name;
    res.redirect(`/vid/${roomID}/?name=${encodeURIComponent(userName)}`);  
})

app.get('/vid/:room', (req, res) => {
    const roomID = req.params.room;
    const userName = req.query.name;
    res.render('room', { roomId: roomID, userName: userName });  
})

app.get('/', (req, res) => {
  res.render('welcome')
})


io.on('connection', socket => {
  socket.on('join-room', (roomId, userId , userName) => {
    const user = userJoin(userId, userName, roomId);
    socket.join(roomId)
    console.log(roomId, userId);
    socket.to(roomId).emit('user-connected', userId)

    io.to(roomId).emit('room-users', {
      room: roomId,
      users: getRoomUsers(roomId)
    })

    socket.on('disconnect', () => {
      const user = userLeave(userId);
      io.to(roomId).emit('room-users', {
        room: roomId,
        users: getRoomUsers(roomId)
      })
      socket.to(roomId).emit('user-disconnected', userId)
    })
  })
})

const PORT = process.env.PORT || 3005;
server.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});