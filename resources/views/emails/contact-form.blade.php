<!DOCTYPE html>
<html>
<head>
    <title>New message from website::</title>
</head>
<body>
    <p>New message from contact form:</p>
    <p><strong>Name:</strong> {{ $data['name'] }}</p>
    <p><strong>Surname:</strong> {{ $data['surname'] }}</p>
    <p><strong>E-mail:</strong> {{ $data['email'] }}</p>
    <p><strong>Phone:</strong> {{ $data['phone'] }}</p>
    <p><strong>Message:</strong> {{ $data['message'] }}</p>
</body>
</html>
