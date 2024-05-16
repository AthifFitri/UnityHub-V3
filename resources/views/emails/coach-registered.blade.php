<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coach Account Registration Notify</title>
</head>

<body>
    <h1>Coach Registered</h1>
    <p>Dear {{ $coach->coachName }},</p>
    <p>We are pleased to inform you that your coach account registration with us has been successfully completed.</p>
    <p>Below are your account details:</p>
    <ul>
        <li><strong>Name:</strong> {{ $coach->coachName }}</li>
        <li><strong>Email:</strong> {{ $coach->coachEmail }}</li>
        <li><strong>Phone Number:</strong> {{ $coach->coachPhone }}</li>
        <li><strong>Industry:</strong> {{ $coach->industry->indName }}</li>
        <li><strong>Password:</strong> Your IC number</li>
    </ul>
    <p>You can log in to your account <a href="{{ route('login') }}">here</a>.</p>
    <p>If you encounter any issues or require assistance, please don't hesitate to reach out to the 2u2i coordinator.
    </p>
    <p>Thank you for choosing to collaborate with us!</p>
</body>

</html>
