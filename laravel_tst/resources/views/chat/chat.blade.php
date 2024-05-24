<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet" href="{{asset('chat/style.css')}}">
  <link rel="shortcut icon" href="{{asset('images/app_logo.png')}}" type="image/x-icon">
  <title>TechoChat</title>
</head>
<body>
  <div class="chat-container">
    <header class="chat-header">
      <h1>Techo<span class="color">Chat</span></h1>
      <a href="index.html" class="btn">
        <i class="fas fa-arrow-right-from-bracket"></i>
      </a>
    </header>
    <main class="chat-main">
      <div class="chat-sidebar">
        <h3>
          <span class="color">
            <i class="fa-solid fa-server"></i>
          </span>
          Channel </h3>
        <h2 id="room-name">asdfs</h2>
        <h3>
          <span class="color">
            <i class="fa-solid fa-users"></i>
          </span>
         Online</h3>
        <ul id="users">
          <li>dssfg</li>
        </ul>
      </div>
      <div class="middle">
        <div class="chat-messages">
          
        </div>
        <div class="chat-form-container">
          <div class="uploadI">
            <form id="uploadImgForm" enctype="multipart/form-data">
              <input type="file" id="imageInput" name="image" accept="image/*" hidden> <br>
              <button type="button" id="uploadButton">
                <i class="fa-regular fa-image"></i>
              </button>
            </form>
          </div>
          <form id="chat-form">
            <input
              id="msg"
              type="text"
              placeholder="Aa"
              required
              autocomplete="off"
            />
            <button class="btn2"><i class="fas fa-paper-plane"></i> </button>
          </form>
        </div>
      </div>
      <div class="uploadC">
        <div class="uploadF">
          <input type="file" id="fileInput">
          <button id="upload" >Upload</button>
          <br>
          <p id="file_name"></p>
        </div>

        <div class="meet">
          <button id="createMeet">
            <i class="fas fa-video"></i>
            <a href="//192.168.0.104:3005/vid?name={{$authUser->name}}" target="__blank">Create Meeting</a>
          </button>
          <input type="text" id="meetId" placeholder="Enter Meet id">
          <input type="hidden" id="userNameH" value={{$authUser->name}}>
          <button id="joinMeet">
            <i class="fas fa-video"></i>
            Or Join Meeting
          </button>
        </div>

      </div>
    </main>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/qs/6.12.0/qs.min.js" integrity="sha512-7guIquo9is/MQs1wfLZyVViTlsvrIoHdnSzoFmPvPMDpqjL2fvDqcVKpaZ9PS3Sbf6DLBRUUZ5X3jcQ/wotWow==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  {{-- <script src="/socket.io/socket.io.js"></script> --}}
  <script src="https://cdn.socket.io/4.7.5/socket.io.min.js" integrity="sha384-2huaZvOR9iDzHqslqwpR87isEmrfxqyWOF7hr7BY6KG0+hVKLoEXMPUJw3ynWuhO" crossorigin="anonymous"></script>
  <script src={{ asset('chat/main.js') }}></script>
</body>
</html>