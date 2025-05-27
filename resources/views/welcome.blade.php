<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
    <div style="text-align: center; margin-top: 50px;">
        <h1>Welcome to My Laravel App!</h1>
        <p>Hello, my name is negar keramat nia</p>
        <p>This is the welcome page in my Informatics Center Request and Support System app.</p>
        <a href="{{ route('login') }}">
            <button style="margin: 10px; padding: 10px 20px;">Login</button>
        </a>
        <a href="{{ route('register') }}">
            <button style="margin: 10px; padding: 10px 20px;">Register</button>
        </a>
    </div>
</body>
</html>