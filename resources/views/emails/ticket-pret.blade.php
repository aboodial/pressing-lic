<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; color: #333; padding: 20px;">

<h2>Votre commande est prête !</h2>

<p>Bonjour {{ $ticket->user->name }},</p>

<p>Bonne nouvelle : votre commande <strong>#{{ $ticket->id }}</strong> au Pressing LIC est maintenant <strong>prête à être récupérée</strong>.</p>

<p>Vous trouverez en pièce jointe le reçu détaillé de votre commande.</p>

<p>N'hésitez pas à passer nous voir pour la récupérer.</p>

<p>Merci de votre confiance,<br>
    Pressing LIC</p>

</body>
</html>
