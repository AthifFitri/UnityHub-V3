<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password Account</title>
</head>

<body>
    <h1>Reset Password Request</h1>
    <p>You are receiving this email because we received a password reset request for your account.</p>
    <p>
        Click <a href="{{ route('reset.password', ['token' => $token, 'email' => $email, 'role' => $role]) }}">here</a>
        to reset your password!
    </p>
    <p>If you did not request a password reset, no further action is required.</p>
</body>

</html>
