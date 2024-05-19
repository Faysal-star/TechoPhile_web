<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="X-UA-Compatible" content="ie=edge" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
		<link rel="stylesheet" href="{{asset('chat/style.css')}}" />
		<title>TechoChat</title>
	</head>
	<body>
		<div class="join-container">
			<!-- <header class="join-header">
				<h1><i class="fas fa-smile"></i> ChatCord</h1>
			</header> -->
			<div class="left">
				<h2>Welcome to</h2><br>
				<h1>TechoChat</h1>
			</div>
			<div class="right">
				<main class="join-main">
					<form action="/chatRoom">
						<div class="form-control">
							<label for="username">Username</label>
							<input
								type="text"
								name="username"
								id="username"
								placeholder="Enter username..."
                                value="{{$authUser->name}}"
								required
                                readonly
							/>
						</div>
						<div class="form-control">
							<label for="room">Room</label>
							<select name="room" id="room">
								<option value="JavaScript">JavaScript</option>
								<option value="Python">Python</option>
								<option value="PHP">PHP</option>
								<option value="C#">C#</option>
								<option value="Ruby">Ruby</option>
								<option value="Java">Java</option>
							</select>
						</div>
						<button type="submit" class="btn">Join Chat</button>
					</form>
				</main>
			</div>
		</div>
	</body>
</html>
