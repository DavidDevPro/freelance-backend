<!-- resources/views/emails/password_reset_confirmation.blade.php -->
@extends('emails.layout')

@section('title')
    Réinitialisation de votre mot de passe pour {{$namewebsite}}
@endsection

@section('content')
<p>Bonjour {{$fullName}},</p>

<p style="margin-bottom: 20px;">
    Vous avez demandé à réinitialiser votre mot de passe pour votre compte sur <strong>{{$namewebsite}}</strong>.
    Veuillez cliquer sur le lien ci-dessous pour réinitialiser votre mot de passe :
</p>

<p style="margin-bottom: 20px;">
    <a href="{{ $resetLink }}" style="background-color: #2283B6; color: white; padding: 10px 20px; text-decoration: none;">Réinitialiser mon mot de passe</a>
</p>

<p style="margin-bottom: 20px;">
    Si vous n'avez pas demandé cette réinitialisation, veuillez ignorer cet email. Votre mot de passe restera inchangé.
</p>

@include('emails.partials.confirmation_signature')
@endsection
