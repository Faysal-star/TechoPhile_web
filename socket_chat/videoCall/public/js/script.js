const modal = document.getElementsByClassName('modal')
const shareScreen = document.getElementById('screen-share')
const socket = io('/')
const videoGrid = document.getElementById('video-grid')

const myPeer = new Peer(undefined, {
  host: '/',
  port: '3008'
})

socket.on('room-users', ({ room, users }) => {
  console.log(room, users)
  let sidePanel = document.querySelector('#memberList')
  sidePanel.innerHTML = `` ;
  if(users[0].username != USER_NAME){
    shareScreen.style.display = 'none'
  }
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
let myCurrentStream;

navigator.mediaDevices.getUserMedia({
  video: true,
  audio: true
}).then(stream => {
  myCurrentStream = stream;
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
      connectToNewUser(userId, myCurrentStream)
    }, 3000)
  });
})

socket.on('user-disconnected', userId => {
  if (peers[userId]) peers[userId].close()
})

myPeer.on('open', id => {
  socket.emit('join-room', ROOM_ID, id, USER_NAME)
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

// Event listener for share screen
shareScreen.addEventListener('click', () => {
  navigator.mediaDevices.getDisplayMedia({
    video: {
      cursor: "always"
    },
    audio: {
      echoCancellation: true,
      noiseSuppression: true
    }
  }).then(stream => {
    switchStream(myCurrentStream, stream);
    myCurrentStream = stream;
  }).catch(err => {
    console.error('Failed to get display media: ', err);
  });
});

function switchStream(oldStream, newStream) {
  // Replace tracks for each peer connection
  Object.values(peers).forEach(peer => {
    const videoSender = peer.peerConnection.getSenders().find(sender => sender.track.kind === 'video');
    if (videoSender) {
      videoSender.replaceTrack(newStream.getVideoTracks()[0]);
    }
  });

  // Update the local video element to show the new stream

  addVideoStream(myVideo, newStream);
}

// if any video is clicked that video size will increase to 100% and again click will remove it
document.addEventListener('click', (e) => {
  if(e.target.tagName === 'VIDEO'){
    if(e.target.style.width === '90vw'){
      e.target.style.width = '98%'
      e.target.style.height = 'auto'
      e.target.style.zIndex = '0'
    }else{
      e.target.style.width = '90vw'
      e.target.style.height = '80vh'
      e.target.style.zIndex = '1000'
    }
  }
})

