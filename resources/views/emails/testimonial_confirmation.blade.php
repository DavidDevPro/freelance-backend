<!-- resources/views/emails/testimonial_confirmation.blade.php -->
@extends('emails.layout')

@section('title', 'Merci pour votre témoignage !')

@section('content')
<p>Bonjour {{ $firstName }} {{ $lastName }},</p>

<p>Nous vous remercions sincèrement pour votre témoignage. Votre avis compte beaucoup pour nous et aide d'autres clients à faire leur choix.</p>

<p>Nous sommes ravis de vous avoir comme client et espérons continuer à vous fournir un excellent service.</p>

@include('emails.partials.confirmation_signature')
@endsection
