<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Confirmation de création d’album</title>
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

        .order-details {
            margin: 32px 0;
            background: #f1f5f9;
            border-radius: 8px;
            padding: 24px;
        }

        .order-details h2 {
            margin-top: 0;
            color: #6c63ff;
            font-size: 1.2rem;
        }

        .order-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-details th,
        .order-details td {
            text-align: left;
            padding: 8px 0;
        }

        .order-details th {
            color: #888;
            font-weight: 400;
        }

        .footer {
            text-align: center;
            color: #aaa;
            font-size: 0.95rem;
            margin-top: 32px;
        }

        .btn {
            display: inline-block;
            background: #6c63ff;
            color: #fff;
            padding: 12px 32px;
            border-radius: 6px;
            text-decoration: none;
            margin-top: 24px;
            font-weight: 600;
            letter-spacing: 1px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Album créé avec succès&nbsp;!</h1>
            <p>Votre album est prêt à être partagé.</p>
        </div>

        <div class="order-details">
            <h2>Détails de l’album</h2>
            <table>
                <tr>
                    <th>Titre de l’album&nbsp;:</th>
                    <td>{{ $album->album_title ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Date du mariage&nbsp;:</th>
                    <td>{{ \Carbon\Carbon::parse($album->wedding_date)->translatedFormat('d F Y') ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Couple&nbsp;:</th>
                    <td>{{ $album->client->mr_first_name }} & {{ $album->client->mrs_first_name }}</td>
                </tr>
                <tr>
                    <th>Email&nbsp;:</th>
                    <td>{{ $album->client->email ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Nombre d’invités max&nbsp;:</th>
                    <td>{{ $album->max_guests ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Statut&nbsp;:</th>
                    <td>{{ ucfirst($album->status) }}</td>
                </tr>
            </table>
            <hr style="margin: 20px 0; border: none; border-top: 1px solid #e2e8f0;">
        </div>

        <div style="text-align:center;">
            <a href="{{ route('albums.show', $album->slug) }}" class="btn">Voir mon album</a>

            {{-- @if ($album->qr_code_path)
                <div style="margin-top: 24px;">
                    <p style="color: #555;">Ou scannez ce QR code :</p>
                    <img src="{{ asset('storage/' . $album->qr_code_path) }}" alt="QR Code"
                         style="width: 160px; height: 160px; object-fit: contain; margin-top: 10px;">
                </div>
            @endif --}}
        </div>

        <div class="footer">
            Si vous avez des questions, répondez à cet email.<br>
            &copy; {{ date('Y') }} Save The Date. Tous droits réservés.
        </div>
    </div>
</body>

</html>
