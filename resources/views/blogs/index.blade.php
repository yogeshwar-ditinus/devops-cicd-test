<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body { font-family: Arial, sans-serif; }
        .blog { margin-bottom: 20px; }
        .blog-title { font-size: 24px; font-weight: bold; }
        .blog-content { font-size: 16px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Blogs</h1>
        @foreach ($blogs as $blog)
            <div class="blog">
                <div class="blog-title">{{ $blog->title }}</div>
                <div class="blog-content">{{ $blog->content }}</div>
            </div>
        @endforeach
    </div>
</body>
</html>
