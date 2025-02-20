<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Post</title>
</head>
<body>
    <x-header></x-header>
    <form action="/store" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image">
        <input type="text" name="title" placeholder="Title">
        <textarea name="content" id="" cols="30" rows="10" placeholder="Content"></textarea>
        <button type="submit">create</button>
    </form>
</body>
</html>