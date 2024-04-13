<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create</title>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
    <link rel="stylesheet" href="{{asset("css/create.css")}}">
</head>
<body>
    <div class="createMain">
        <h2>Create Post</h2>
    
        <div class="createForm">
            <form action="/store" method="post">
                @csrf
    
                <label for="title"> Title </label> 
                <input type="text" name="title" id="title"
                value="{{old('title')}}">
                @error('title')
                        <p class="errText">{{ $message }}</p>
                @enderror
    
                <label for="tags"> Tags </label>
                <input type="text" name="tags" id="tags"
                value="{{old('tags')}}">
    
                @error('tags')
                        <p class="errText">{{ $message }}</p>
                @enderror

                <label for="body">Description</label> <br>
                <textarea class="body" id="body" name="body"
                rows="10" cols="50">
                </textarea>
                @error('body')
                    <p class="errText">{{ $message }}</p>
                @enderror
                <br>
                <button>Create</button>
            </form>
        </div>
    </div>



    <script>
        ClassicEditor
            .create( document.querySelector( '#body' ),
            {
                ckfinder:{
                    uploadUrl : "{{route('upload.pic',['_token' => csrf_token()])}}" ,
                }
            } )
            .catch( error => {
                console.error( error );
            } );
    </script>
</body>
</html>