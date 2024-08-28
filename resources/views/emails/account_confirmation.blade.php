<!-- resources/views/emails/account_confirmation.blade.php -->
@extends('emails.layout')

@section('title')
    Votre espace client a été créé avec succès sur {{$namewebsite}}
@endsection

@section('content')
<p>Bonjour {{$fullName}},</p>

<p style="margin-bottom: 20px;">
    Votre espace client a été créé avec succès sur <strong>{{$linkwebsite}}</strong>. Voici les détails de votre compte :
</p>

<table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
    <tr>
        <td style="padding: 8px; border: 1px solid #dddddd; background-color: #f9f9f9;">
            <strong style="color: #2283B6;">Identifiant :</strong>
        </td>
        <td style="padding: 8px; border: 1px solid #dddddd;">
            {{ $username }}
        </td>
    </tr>
    <tr>
        <td style="padding: 8px; border: 1px solid #dddddd; background-color: #f9f9f9;">
            <strong style="color: #2283B6;">Mot de passe :</strong>
        </td>
        <td style="padding: 8px; border: 1px solid #dddddd;">
            <em>Vous recevrez un second mail contenant votre mot de passe.</em>
        </td>
    </tr>
</table>

<p style="margin-bottom: 20px;">
    Vous pouvez dès à présent vous connecter à votre espace client pour gérer vos projets.
</p>

@include('emails.partials.confirmation_signature')
@endsection
