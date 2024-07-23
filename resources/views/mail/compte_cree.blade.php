<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tache Assignee</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            padding: 20px;
            background-color: #ffffff;
            margin: 0 auto;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding: 20px 0;
        }
        .header img {
            width: 100px;
        }
        .content {
            padding: 20px;
            line-height: 1.6;
            color: #333333;
        }
        .content h1 {
            color: #333333;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #666666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="logo_url" alt="Company Logo">
        </div>
        <div class="content">
            <h1>Bonjour {{ $prenom }} {{ $nom }},</h1>
            <p>Un compte en votre nom vient d'etre cree, vous pouvez maintanant vous rendre sur la <a href="{{route('login')}}">plateforme</a>.</p>
            <p>Votre mot de passe est " {{$passwd}} " (Il conviendrait de le changer).</p>
            <p>Merci,</p>
            <p>L'équipe de gestion des tâches</p>
        </div>
        <div class="footer">
            &copy; 2024 MyTask. Tous droits réservés.
        </div>
    </div>
</body>
</html>
