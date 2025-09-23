<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Invitation à partager vos photos</title>
    <style>
        body {
            background: #f8fafc;
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            background: #fff;
            max-width: 600px;
            margin: 40px auto;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.07);
            padding: 40px 30px;
        }

        .header {
            text-align: center;
            padding-bottom: 24px;
        }

        .header h1 {
            color: #6c63ff;
            margin: 0;
            font-size: 2rem;
        }

        .album-invitation {
            margin: 32px 0;
            background: #f1f5f9;
            border-radius: 8px;
            padding: 24px;
        }

        .album-invitation h2 {
            margin-top: 0;
            color: #6c63ff;
            font-size: 1.2rem;
        }

        .album-invitation table {
            width: 100%;
            border-collapse: collapse;
        }

        .album-invitation th,
        .album-invitation td {
            text-align: left;
            padding: 8px 0;
        }

        .album-invitation th {
            color: #888;
            font-weight: 400;
        }

        /* Styles pour centrer le bouton */
        .btn-container {
            text-align: center;
            margin-top: 24px;
        }

        .btn {
            display: inline-block;
            background: #6c63ff;
            color: #fff;
            padding: 12px 32px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .footer {
            text-align: center;
            color: #aaa;
            font-size: 0.95rem;
            margin-top: 32px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Invitation à partager vos photos</h1>
        </div>

        <div class="mt-4">
            <p>Salut&nbsp;<strong>{{ ucfirst($uploadToken->visitor_name) }}</strong>!</p>
            <p>Le couple<strong>&nbsp;{{ ucfirst($album->client->mr_first_name) }}&nbsp;{{ ucfirst($album->client->mr_last_name) }}&nbsp;💍&nbsp;
                {{ ucfirst($album->client->mrs_first_name) }}&nbsp;{{ ucfirst($album->client->mrs_last_name) }}&nbsp;</strong> vous invitent à partager vos photos pour l'album de leur mariage.
            </p>
        </div>

        <div class="album-invitation mt-4">
            <h2>Invitation à l’album</h2>
            <table>
                <tr>
                    <th>Titre de l’album&nbsp;:</th>
                    <td>{{ ucfirst($album->album_title) ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Date du mariage&nbsp;:</th>
                    <td>{{ \Carbon\Carbon::parse($album->wedding_date)->translatedFormat('d F Y') ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Couple&nbsp;:</th>
                    <td>{{ ucfirst($album->client->mr_first_name) }}&nbsp;{{ ucfirst($album->client->mr_last_name) }}&nbsp;💍&nbsp;
                {{ ucfirst($album->client->mrs_first_name) }}&nbsp;{{ ucfirst($album->client->mrs_last_name) }}</td>
                </tr>
                <tr>
                    <th>Valide jusqu'au&nbsp;:</th>
                    <td>{{ \Carbon\Carbon::parse($uploadToken->expires_at)->translatedFormat('d F Y') ?? 'N/A' }}</td>
                </tr>
            </table>
            <hr style="margin: 20px 0; border: none; border-top: 1px solid #e2e8f0;">

            <div class="btn-container">
                <a href="{{ route('photos.upload.token', [$album->slug, $uploadToken->token]) }}" class="btn">Partager vos photos</a>
            </div>
        </div>

        <div class="footer">
            Si vous avez des questions, répondez à cet email.<br>
            &copy; {{ date('Y') }} Save The Date. Tous droits réservés.
        </div>
    </div>
</body>

</html>