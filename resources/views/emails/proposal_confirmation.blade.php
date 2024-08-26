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
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Confirmation de votre demande de devis</h2>
        </div>
        <div class="content">
            <p>Bonjour {{$fullName}},</p>
            <p>Merci d'avoir choisi notre service pour votre demande de devis. Nous avons bien reçu votre demande pour la formule <strong>{{$formule}}</strong>.</p>
            <p>Nous reviendrons vers vous dans les plus brefs délais pour vous fournir plus de détails et vous assister dans votre projet.</p>
            <p>Cordialement,<br>L'équipe de David Web Projects</p>
        </div>
        <div class="footer">
            <p>&copy; {{date('Y')}} David Web Projects. Tous droits réservés.</p>
        </div>
    </div>
</body>

</html>