function getLocalIPv4(callback) {
    const RTCPeerConnection = window.RTCPeerConnection || window.webkitRTCPeerConnection || window.mozRTCPeerConnection;
    const peerConnection = new RTCPeerConnection({iceServers: []});
    peerConnection.createDataChannel('');
    peerConnection.createOffer(offer => peerConnection.setLocalDescription(offer), error => {});
    peerConnection.onicecandidate = function(event) {
        if (event && event.candidate && event.candidate.candidate) {
            const ipAddress = event.candidate.candidate.split(' ')[4];
            const ipv4Regex = /^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$/;
            if (ipv4Regex.test(ipAddress)) {
                callback(ipAddress);
            }
        }
    };
}

let ip = '';
var io = io.connect(`/`);

const Ipv4address = getLocalIPv4(ip => {
    console.log(ip);
    ip = ip;
    io = io.connect(`http://${ip}:3005`);
});

let canvas = document.getElementById('canvas');
const colorPicker = document.getElementById('colorPicker');
const penWidth = document.getElementById('penWidth');
const clearButton = document.getElementById('clearButton');
const saveButton = document.getElementById('saveButton');
const eraserButton = document.getElementById('eraserButton');

canvas.width = window.innerWidth - 50;
canvas.height = window.innerHeight - 50;



let ctx = canvas.getContext('2d');
ctx.lineJoin = 'round';
ctx.lineCap = 'round';

window.addEventListener('resize', () => {
    const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
    canvas.width = window.innerWidth - 50;
    canvas.height = window.innerHeight - 50;
    ctx.putImageData(imageData, 0, 0);
});

let x , y ;
let isErasing = false;

canvas.addEventListener('mousedown', (e) => {
    x = e.clientX;
    y = e.clientY;
    canvas.addEventListener('mousemove', draw);
});

canvas.addEventListener('mouseup', () => {
    canvas.removeEventListener('mousemove', draw);
});

canvas.addEventListener('touchstart', (e) => {
    const touch = e.touches[0];
    x = touch.clientX;
    y = touch.clientY;
    canvas.addEventListener('touchmove', draw);
});

canvas.addEventListener('touchend', () => {
    canvas.removeEventListener('touchmove', draw);
});



io.on('onDraw', (data) => {
    ctx.strokeStyle = data.color;
    ctx.lineWidth = data.penWidth;
    ctx.beginPath();
    ctx.moveTo(data.x, data.y);
    ctx.lineTo(data.clientX, data.clientY);
    ctx.stroke();
});

io.on('onClear', () => {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
});

function draw(e) {
    const rect = canvas.getBoundingClientRect();
    let clientX, clientY;
    if (e.type === 'touchmove') {
        clientX = e.touches[0].clientX - rect.left;
        clientY = e.touches[0].clientY - rect.top;
    } else {
        clientX = e.clientX - rect.left;
        clientY = e.clientY - rect.top;
    }

    io.emit('draw', {
        x: x,
        y: y,
        clientX: clientX,
        clientY: clientY,
        color: isErasing ? 'white' : colorPicker.value,
        penWidth: penWidth.value
    });

    ctx.strokeStyle = colorPicker.value;
    if(isErasing) ctx.strokeStyle = 'white';
    ctx.lineWidth = penWidth.value;
    ctx.beginPath();
    ctx.moveTo(x, y);
    ctx.lineTo(clientX, clientY);
    ctx.stroke();
    x = e.clientX;
    y = e.clientY;
}

clearButton.addEventListener('click', () => {
    io.emit('clear' ,{})
    ctx.clearRect(0, 0, canvas.width, canvas.height);
});

saveButton.addEventListener('click', () => {
    const image = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
    const link = document.createElement('a');
    link.download = 'whiteboard.png';
    link.href = image;
    link.click();
});

eraserButton.addEventListener('click', () => {
    isErasing = !isErasing;
    eraserButton.textContent = isErasing ? 'Draw' : 'Eraser';
    eraserButton.classList.toggle('eraser');
});