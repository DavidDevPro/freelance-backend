<!-- resources/views/emails/password_confirmation.blade.php -->
@extends('emails.layout')

@section('title')
    Votre mot de passe pour accéder à votre espace client sur {{$namewebsite}}
@endsection

@section('content')
<p>Bonjour {{$fullName}},</p>

<p style="margin-bottom: 20px;">
    Comme mentionné précédemment, voici votre mot de passe pour accéder à votre espace client sur <strong>{{$linkwebsite}}</strong> :
</p>

<table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
    <tr>
        <td style="padding: 8px; border: 1px solid #dddddd; background-color: #f9f9f9;">
            <strong style="color: #2283B6;">Identifiant :</strong>
        </td>
        <td style="padding: 8px; border: 1px solid #dddddd;">
            voir mail précedent
        </td>
    </tr>
    <tr>
        <td style="padding: 8px; border: 1px solid #dddddd; background-color: #f9f9f9;">
            <strong style="color: #2283B6;">Mot de passe :</strong>
        </td>
        <td style="padding: 8px; border: 1px solid #dddddd;">
            {{ $password }}
        </td>
    </tr>
</table>

<p style="margin-bottom: 20px;">
    Nous vous recommandons de changer ce mot de passe dès votre première connexion pour assurer la sécurité de votre compte.
</p>

@include('emails.partials.confirmation_signature')
@endsection
