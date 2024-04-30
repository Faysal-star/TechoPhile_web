const modal = document.getElementsByClassName('modal')


const socket = io('/')
const videoGrid = document.getElementById('video-grid')

const myPeer = new Peer(undefined, {
  host: '/',
  port: '3006'
})

socket.on('room-users', ({ room, users }) => {
  console.log(room, users)
  let sidePanel = document.querySelector('.sidePanel')
  sidePanel.innerHTML = `
            <h2>Meeting Id</h2>
            <p id='roomID'>${ROOM_ID}</p>
            <h2>Members</h2>` ;
  for(let user of users){
    let userDiv = document.createElement('div')
    userDiv.classList.add('user')
    userDiv.innerText = user.username
    sidePanel.appendChild(userDiv)
  }
  document.getElementById('roomID').addEventListener('click', () => {
    // alert('Meeting Id copied to clipboard')
    navigator.clipboard.writeText(ROOM_ID)
    .then(() => {
      alert('Meeting Id copied to clipboard');
    })
    .catch((error) => {
      console.error('Unable to copy text to clipboard:', error);
      alert('Unable to copy text to clipboard. Please copy it manually.');
    });
  })
})





const myVideo = document.createElement('video')
myVideo.muted = true
const peers = {}
navigator.mediaDevices.getUserMedia({
  video: true,
  audio: true
}).then(stream => {
addVideoStream(myVideo, stream)
  myPeer.on('call', call => {
    call.answer(stream)
    const video = document.createElement('video')
    call.on('stream', userVideoStream => {
      addVideoStream(video, userVideoStream)
    })
  })

  socket.on('user-connected', userId => {
    setTimeout(() => {
      connectToNewUser(userId, stream)
    }, 3000)
  })
})

socket.on('user-disconnected', userId => {
  if (peers[userId]) peers[userId].close()
})

myPeer.on('open', id => {
  socket.emit('join-room', ROOM_ID, id , USER_NAME)
})

function connectToNewUser(userId, stream) {
  const call = myPeer.call(userId, stream)
  const video = document.createElement('video')
  call.on('stream', userVideoStream => {
    addVideoStream(video, userVideoStream)
  })
  call.on('close', () => {
    video.remove()
  })

  peers[userId] = call
}

function addVideoStream(video, stream) {
  video.srcObject = stream
  video.addEventListener('loadedmetadata', () => {
    video.play()
  })
    videoGrid.append(video)
}