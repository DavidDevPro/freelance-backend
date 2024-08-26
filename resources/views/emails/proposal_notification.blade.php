<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
        }

        p {
            color: #666;
        }

        .container {
            padding: 20px;
            max-width: 600px;
            margin: auto;
        }

        .header {
            background-color: #f8f8f8;
            padding: 10px;
            text-align: center;
        }

        .content {
            margin: 20px 0;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #999;
        }

        .highlight {
            padding: 12px;
            border-left: 4px solid #d0d0d0;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Nouvelle demande de devis reçue</h2>
        </div>
        <div class="content">
            <p>Bonjour,</p>
            <p>Vous avez reçu une nouvelle demande de devis de la part de {{$firstName}} {{$lastName}}.</p>
            <p><strong>Détails de la demande :</strong></p>
            <p class="highlight">Formule choisie : {{$formule}}</p>
            <p class="highlight">Email de contact : {{$email}}</p>
            <p class="highlight">Numéro de téléphone : {{$phone}}</p>
            <p class="highlight">Ville : {{$city}}</p>
            <p>Cordialement,<br>Le système de notifications de David Web Projects</p>
        </div>
        <div class="footer">
            <p>&copy; {{date('Y')}} David Web Projects. Tous droits réservés.</p>
        </div>
    </div>
</body>

</html>