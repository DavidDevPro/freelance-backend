<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <style>
    body {
      font-family: 'Arial', sans-serif;
      color: #333;
      line-height: 1.6;
      margin: 0;
      padding: 0;
      background-color: #ffffff;
      /* Forcer un fond blanc */
    }

    .container {
      padding: 20px;
      max-width: 600px;
      margin: auto;
      background-color: #ffffff;
      /* Forcer un fond blanc */
      border-radius: 8px;
      box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
    }

    .header {
      text-align: center;
      margin-bottom: 20px;
    }

    .logo {
      max-width: 80px;
      margin-bottom: 10px;
    }

    .title {
      color: #2283B6;
      font-size: 26px;
      font-weight: bold;
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
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
      background-color: #f9f9f9;
      border-radius: 4px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <img src="https://apifreelance.davidwebprojects.fr/signature_images/logo.png" alt="Logo davidWebProjects" class="logo">
      <h2 class="title">@yield('title')</h2>
    </div>
    <div class="content">
      @yield('content')
    </div>
    <div class="footer">
      <p>&copy; {{ date('Y') }} David Web Projects. Tous droits réservés.</p>
    </div>
  </div>
</body>

</html>