<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Arial', sans-serif; color: #333; line-height: 1.6; }
        .signature-container { display: flex; align-items: center; margin-top: 20px; }
        .profile-image { border-radius: 50%; width: 150px; height: 150px; margin-right: 20px; }
        .signature-info {
            font-size: 14px;
            color: #333;
            padding-left: 20px;
            border-left: 2px solid #2283B6; /* Ligne verticale à gauche de la div */
        }
        .signature-info p { margin: 5px 0; color: #2283B6; }
        .signature-info a { color: #2283B6; text-decoration: none; }
        .signature-info a:hover { text-decoration: underline; }
        .icon-text { display: flex; align-items: center; margin-bottom: 5px; color: #2283B6; }
        .icon-text img { width: 18px; height: 18px; margin-right: 8px; vertical-align: middle; }
        .social-icons { margin-top: 10px; }
        .social-icons img { width: 32px; height: 32px; margin-right: 10px; }
        .social-text { margin-top: 10px; font-weight: bold; color: #2283B6; }
    </style>
</head>
<body>
    <p>Cordialement,</p>
    <div class="signature-container">
        <img class="profile-image" src="{{ url('/signature_images/profil.jpg') }}" alt="Profile">
        <div class="signature-info">
            <p><strong>MAGNAN DE BELLEVUE Fabrice</strong><br>
            Dirigeant <strong>FabWebProjects</strong></p>
            <div class="icon-text">
                <img src="{{ url('/signature_images/mobile.png') }}" alt="Phone">
                <span>06 68 64 12 43</span>
            </div>
            <div class="icon-text">
                <img src="{{ url('/signature_images/mail.png') }}" alt="Email">
                <span>contact@fabwebprojects.fr</span>
            </div>
            <p>
                <img src="{{ url('/signature_images/internet.png') }}" alt="Website" style="width: 18px; height: 18px; vertical-align: middle; margin-right: 8px;">
                <a href="https://www.fabwebprojects.fr">www.fabwebprojects.fr</a>
            </p>
            <p class="social-text">Retrouvez-moi sur les réseaux sociaux :</p>
            <div class="social-icons">
                <a href="https://www.linkedin.com/company/fabwebprojects"><img src="{{ url('/signature_images/linkedin.png') }}" alt="LinkedIn"></a>
                <a href="https://github.com/fabwebprojects"><img src="{{ url('/signature_images/github.png') }}" alt="GitHub"></a>
                <a href="https://www.facebook.com/fabwebprojects"><img src="{{ url('/signature_images/facebook.png') }}" alt="Facebook"></a>
                <a href="https://x.com/FabWebProjects"><img src="{{ url('/signature_images/twitter.png') }}" alt="Twitter"></a>
                <a href="https://www.instagram.com/fabwebprojects/"><img src="{{ url('/signature_images/instagram.png') }}" alt="Instagram"></a>
            </div>
        </div>
    </div>
</body>
</html>
