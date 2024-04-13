function uploadFile() {
    var fileInput = document.getElementById('fileInput');
    var file = fileInput.files[0];
    var formData = new FormData();
    formData.append('file', file);

    file_name = file.name;

    // set the filename in session storage
    sessionStorage.setItem('file_name', file_name);


    // var xhr = new XMLHttpRequest();
    // xhr.open('POST', 'http://127.0.0.1:5000/upload', true);
    // xhr.onload = function () {
    //     if (xhr.status === 200) {
    //         alert('File uploaded successfully');
    //     } else {
    //         alert('Error uploading file');
    //     }
    // };
    // xhr.send(formData);

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

function askQuestion(){
    var question = document.getElementById('question').value;
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


function pushAns(ques , data){
    document.getElementById('loading').innerHTML = '';
    let allQ = document.getElementById('allQ');
    let unitQ = `
        <div class="unitQ">
                <p class="ques">${ques}</p>
                <p class="ans">${data}</p>
        </div>
    `

    allQ.innerHTML = unitQ + allQ.innerHTML;
}

document.getElementById("file_name").innerHTML = sessionStorage.getItem('file_name');
document.getElementById('upload').addEventListener('click', function(e){
    e.preventDefault();
    uploadFile();
    document.getElementById("file_name").innerHTML = sessionStorage.getItem('file_name');
});

document.getElementById('ask').addEventListener('click', function(e){
    e.preventDefault();
    document.getElementById('loading').innerHTML = 'Thinkingg...';
    askQuestion();
    document.getElementById('question').value = '';
});