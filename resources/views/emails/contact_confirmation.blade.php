<!-- resources/views/emails/contact_confirmation.blade.php -->
@extends('emails.layout')

@section('title', 'Confirmation de votre demande de contact')

@section('content')
<p>Bonjour {{ $from_name }},</p>
<p>Merci pour votre message. Nous avons reçu votre demande et nous vous répondrons sous 48h hors weekends.</p>

@include('emails.partials.confirmation_signature')
@endsection
