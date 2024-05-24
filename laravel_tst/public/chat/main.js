const chatForm = document.getElementById('chat-form');

const { username , room } = Qs.parse(location.search, {
    ignoreQueryPrefix: true
});

const socket = io("192.168.0.104:3000") || io("localhost:3000");

// Join chatroom
socket.emit('joinRoom', { username, room });


// Get room and users
socket.on('roomUsers', ({ room, users }) => {
    outputRoomName(room);
    outputUsers(users);
})

function outputRoomName(room) {
    document.getElementById('room-name').innerText = room;
}

function outputUsers(users) {
    document.getElementById('users').innerHTML = `
        ${users.map(user => `<li>${user.username}</li>`).join('')}
    `;
}

// Message from server
socket.on('message', message => {
    console.log(message);
    outputMessage(message);

    // Scroll down
    document.querySelector('.chat-messages').scrollTop = document.querySelector('.chat-messages').scrollHeight;
})


chatForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const msg = e.target.elements.msg.value;
    // console.log(msg);
    // if msg contains @ask then ask question
    socket.emit('chatMessage', msg);
    if(msg.includes('@file')){
        askQuestion(msg);
    }
    else if(msg.includes('@ask')){
        askGQuestion(msg);
    }
    e.target.elements.msg.value = '';
    e.target.elements.msg.focus();
})

// console.log("HOla");

const uploadImgForm = document.getElementById('uploadImgForm');
const imageInput = document.getElementById('imageInput');
const uploadButton = document.getElementById('uploadButton');
uploadButton.addEventListener('click', function(e) {
    e.preventDefault();
    console.log("added");
    const formData = new FormData();
    formData.append('image', imageInput.files[0]);

    fetch('http://192.168.0.104:3000/uploadImg', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.imageUrl) {
        socket.emit('chatMessage', `<img src="${data.imageUrl}" alt="image" class="chat-img" />`);
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
});

document.addEventListener('click', function(event) {
    if (event.target.classList.contains('chat-img')) {
        const imageUrl = event.target.src;
        window.open(imageUrl, '_blank');
    }
});

function outputMessage(message) {
    const div = document.createElement('div');
    div.classList.add('message');
    div.innerHTML = `<p class="meta">${message.username} <span>${message.time}</span></p>
    <p class="text">
        ${message.text}
    </p>`;
    document.querySelector('.chat-messages').appendChild(div);
}




// chat pdf section
function uploadFile() {
    var fileInput = document.getElementById('fileInput');
    var file = fileInput.files[0];
    var formData = new FormData();
    formData.append('file', file);

    file_name = file.name;
    sessionStorage.setItem('file_name', file_name);

    socket.emit('Bot', `@file ${file_name} has been uploaded`);

    fetch('http://127.0.0.1:5000/upload', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
        // alert('File uploaded successfully');
    })
}

function askQuestion(question){
    // fetch
    fetch('http://127.0.0.1:5000/get_question', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({question: question}),
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
        pushAns(question , data) ;
    })
}

function askGQuestion(question){
    // fetch
    fetch('http://127.0.0.1:5000/get_general_question', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({question: question}),
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
        pushAns(question , data) ;
    })
}

function pushAns(ques , data){
    socket.emit('botMessage', data);
}

document.getElementById("file_name").innerHTML = sessionStorage.getItem('file_name');
document.getElementById('upload').addEventListener('click', function(e){
    e.preventDefault();
    uploadFile();
    document.getElementById("file_name").innerHTML = sessionStorage.getItem('file_name');
});


let meetBtn = document.getElementById('joinMeet');
let meetId = document.getElementById('meetId');
let userName = document.getElementById('userNameH');

meetBtn.addEventListener('click', function(e){
    e.preventDefault();
    let meetIdValue = meetId.value;
    let userNameValue = userName.value;
    console.log(meetIdValue);
    // redirect window to /vid/id
    window.location.href = `//192.168.0.104:3005/vid/${meetIdValue}/?name=${userNameValue}`;
})

