<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #1E3A5F;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f0f0f0;
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total {
            font-weight: bold;
            font-size: 16px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<h1>Reçu - Pressing LIC</h1>

<p><strong>Ticket n° :</strong> {{ $ticket->id }}</p>
<p><strong>Client :</strong> {{ $ticket->user->name }}</p>
<p><strong>Date :</strong> {{ $ticket->created_at->format('d/m/Y à H:i') }}</p>

<table>
    <thead>
    <tr>
        <th>Service</th>
        <th class="text-center">Quantité</th>
        <th class="text-right">Prix unitaire</th>
        <th class="text-right">Sous-total</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($ticket->lignes as $ligne)
        <tr>
            <td>{{ $ligne->service->libelle }}</td>
            <td class="text-center">{{ $ligne->quantite }}</td>
            <td class="text-right">{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }} FCFA</td>
            <td class="text-right">{{ number_format($ligne->quantite * $ligne->prix_unitaire, 0, ',', ' ') }} FCFA</td>
        </tr>
    @endforeach
    </tbody>
</table>

<p class="total text-right">
    Montant total : {{ number_format($ticket->lignes->sum(fn($l) => $l->quantite * $l->prix_unitaire), 0, ',', ' ') }} FCFA
</p>

<p>Merci de votre confiance,<br>Pressing LIC</p>

</body>
</html>
