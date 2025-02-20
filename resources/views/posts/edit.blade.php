<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Post</title>
</head>
<body>
    <x-header></x-header>
    <form action="/update/{{ $postArray['id'] }}" method="post">
        @csrf
        @method('put')
        <input type="text" name="title" placeholder="Title" value="{{ $postArray['title'] }}">
        <textarea name="content" id="" cols="30" rows="10" placeholder="Content" value="{{ $postArray['content'] }}"></textarea>
        <button type="submit">update</button>
    </form>
</body>
</html>