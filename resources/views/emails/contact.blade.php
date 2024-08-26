<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        p {
            color: #666;
        }
    </style>
</head>

<body>
    <p>Bonjour david,</p>
    <p>Vous avez reçu une demande via le formulaire de contact du site David Web Projects de {{$from_name}}:</p>
    <p style="padding: 12px; border-left: 4px solid #d0d0d0; font-style: italic;">Objet du mail : {{$subject}}</p>
    <p style="padding: 12px; border-left: 4px solid #d0d0d0; font-style: italic;">Mail de Contact : {{$email}}</p>
    <p style="padding: 12px; border-left: 4px solid #d0d0d0; font-style: italic;">Message : {{$userMessage}}</p>
    <p>Cordialement,<br>david, le Webmaster de David Web Projects.fr</p>
</body>

</html>