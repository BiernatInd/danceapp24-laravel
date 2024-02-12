<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login details</title>
</head>
<body>
    <h1>Login details</h1>
    <p>E-mail: {{ $user -> email }}</p>
    <p>Hasło: {{ $password}}</p>

    <a href="https://danceconnect24.com/login" target="_blank">https://danceconnect24.com/login</a>
</body>
</html>