<!-- resources/views/emails/contact_notification.blade.php -->
@extends('emails.layout')

@section('title', 'Nouvelle demande de contact reçue')

@section('content')
<p>Bonjour David,</p>

<p style="margin-bottom: 20px;">
    Vous avez reçu une nouvelle demande de contact depuis le site <strong>{{$namewebsite}}</strong>. Voici les détails de la demande :
</p>

<table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
    <tr>
        <td style="padding: 8px; border: 1px solid #dddddd; background-color: #f9f9f9;"><strong style="color: #2283B6;">Nom :</strong></td>
        <td style="padding: 8px; border: 1px solid #dddddd;">{{$from_name}}</td>
    </tr>
    <tr>
        <td style="padding: 8px; border: 1px solid #dddddd; background-color: #f9f9f9;"><strong style="color: #2283B6;">Objet du mail :</strong></td>
        <td style="padding: 8px; border: 1px solid #dddddd;">{{$subject}}</td>
    </tr>
    <tr>
        <td style="padding: 8px; border: 1px solid #dddddd; background-color: #f9f9f9;"><strong style="color: #2283B6;">Email de contact :</strong></td>
        <td style="padding: 8px; border: 1px solid #dddddd;"><a href="mailto:{{$email}}" style="color: #2283B6;">{{$email}}</a></td>
    </tr>
    <tr>
        <td style="padding: 8px; border: 1px solid #dddddd; background-color: #f9f9f9;"><strong style="color: #2283B6;">Numéro de téléphone :</strong></td>
        <td style="padding: 8px; border: 1px solid #dddddd;">{{$phone}}</td>
    </tr>
    <tr>
        <td style="padding: 8px; border: 1px solid #dddddd; background-color: #f9f9f9;"><strong style="color: #2283B6;">Message :</strong></td>
        <td style="padding: 8px; border: 1px solid #dddddd;">{{$userMessage}}</td>
    </tr>
</table>

@include('emails.partials.notification_signature')
@endsection