<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; color: #333; padding: 20px;">

<h2>Confirmation de votre commande</h2>

<p>Bonjour {{ $ticket->user->name }},</p>

<p>Nous avons bien reçu votre commande <strong>#{{ $ticket->id }}</strong> au Pressing LIC. Voici le récapitulatif :</p>

<table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
    <thead>
    <tr style="background-color: #f0f0f0;">
        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Service</th>
        <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Quantité</th>
        <th style="border: 1px solid #ddd; padding: 8px; text-align: right;">Prix unitaire</th>
        <th style="border: 1px solid #ddd; padding: 8px; text-align: right;">Sous-total</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($ticket->lignes as $ligne)
        <tr>
            <td style="border: 1px solid #ddd; padding: 8px;">{{ $ligne->service->libelle }}</td>
            <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ $ligne->quantite }}</td>
            <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }} FCFA</td>
            <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">{{ number_format($ligne->quantite * $ligne->prix_unitaire, 0, ',', ' ') }} FCFA</td>
        </tr>
    @endforeach
    </tbody>
</table>

<p><strong>Montant total : {{ number_format($ticket->lignes->sum(fn($l) => $l->quantite * $l->prix_unitaire), 0, ',', ' ') }} FCFA</strong></p>

<p>Votre commande est actuellement au statut : <strong>{{ $ticket->statut }}</strong>.</p>

<p>Vous serez informé par email dès que votre commande sera prête à être récupérée.</p>

<p>Merci de votre confiance,<br>
    Pressing LIC</p>

</body>
</html>
