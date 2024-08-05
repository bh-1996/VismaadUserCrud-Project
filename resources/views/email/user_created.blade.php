<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome</title>
</head>
<body>
    <h1>Welcome to Our Application, {{ capitalizedString($user->name) ?? 'User' }}!</h1>
    <p>Thank you for registering with us. We are excited to have you on board.</p>
    <p>Your registered email: {{ $user->email ?? 'abc@example.com' }}</p>
    <br>
    <p>Best regards,</p>
    <p>Vismaad Mediatech Pvt Ltd</p>
    <p>Date : {{ formatDate($date) }}</p>
</body>
</html>
