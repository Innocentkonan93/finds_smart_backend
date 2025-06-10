<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
</head>
<body>
    <h3>Hello {{ $user->name }},</h3>
    <p>Merci de vous être inscrit. Votre code de vérification est : <strong>{{ $user->email_verification_code }}</strong></p>
    <p>Veuillez entrer ce code dans l'application pour vérifier votre compte.</p>
</body>
</html>
