let factCheckResult = document.getElementById('factCheckResult');

let blogText = document.getElementById('blogText').innerText;

factCheckResult.addEventListener('click' , function(e){
    let prompt = "Check the factuality of the blog post. If any false information is found, please provide the correct information. Don't prepend anything other than fact check result. Blog post:" + blogText;
    askGQuestion(prompt);
})

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
        factCheckResult.innerText = data;
    })
} 


document.addEventListener("DOMContentLoaded", function() {
    var replyButtons = document.querySelectorAll('.replyShow');

    replyButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var form = button.nextElementSibling;

            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'flex';
            } else {
                form.style.display = 'none';
            }
        });
    });
});