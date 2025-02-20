<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Posts Index</title>
</head>

<body>
    <x-header></x-header>
    @foreach ($postArray as $post)
        <img src="{{ asset('/storage/' . $post['image']) }}" alt="">
        <h1>{{ $post['title'] }}</h1>
        <p>{{ $post['content'] }}</p>
        <a href="/show/{{ $post['id'] }}">selengkapnya</a>
        <a href="/edit/{{ $post['id'] }}">edit</a>
        <form action="/delete/{{ $post['id'] }}" method="post">
            @csrf
            @method('delete')
            <button type="submit">hapus</button>
        </form>
    @endforeach
</body>

</html>
