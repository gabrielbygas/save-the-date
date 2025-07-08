<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Confirmation de commande</title>
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
            <h1>Merci pour votre commande&nbsp;!</h1>
            <p>Votre commande a été confirmée.</p>
        </div>

        <div class="order-details">
            <h2>Résumé de la commande</h2>
            <table>
                <tr>
                    <th>Numéro de commande&nbsp;:</th>
                    <td>{{ $order->confirmation_number ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Date&nbsp;:</th>
                    <td>{{ $order->wedding_date->translatedFormat('d F Y') ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Couple&nbsp;:</th>
                    <td>{{ $order->wedding_title ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Email&nbsp;:</th>
                    <td>{{ $order->client->email ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Theme&nbsp;:</th>
                    <td>{{ $order->theme->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th><strong>Prix&nbsp;:</strong></th>
                    <td><strong>{{ isset($order->pack->price) ? intval($order->pack->price) : 'N/A' }}&nbsp;$</strong>
                    </td>
                </tr>
            </table>
            <hr style="margin: 20px 0; border: none; border-top: 1px solid #e2e8f0;">

        </div>

        <div style="text-align:center;">
            <p> Vous disposez de 3 jours ouvrables, jusqu'au
                <strong>{{ $order->payment_due_at->translatedFormat('d F Y') }}</strong>, pour effectuer le paiement.</p>
            <p> Le paiement se fait uniquement par mobile money ou en espèces. Notre service client vous contactera pour
                vous assister.</p>
        </div>

        <div class="footer">
            Si vous avez des questions, répondez à cet email.<br>
            &copy; {{ date('Y') }} Save The Date. Tous droits réservés.
        </div>
    </div>
</body>

</html>
