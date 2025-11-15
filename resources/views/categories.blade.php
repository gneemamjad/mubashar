<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>إدارة الكاتيغوري</title>
</head>
<body>
    <h1>الكاتيغوري</h1>

    @foreach($categories as $category)
        @include('categories.partials.node', ['node' => $category])
    @endforeach
</body>
</html>
