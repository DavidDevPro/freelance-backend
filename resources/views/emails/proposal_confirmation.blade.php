<!-- resources/views/emails/proposal_confirmation.blade.php -->
@extends('emails.layout')

@section('title', 'Confirmation de votre demande de devis')

@section('content')
    <p>Bonjour {{$fullName}},</p>
    <p>Merci d'avoir choisi notre service pour votre demande de devis. Nous avons bien reçu votre demande pour la formule <strong>{{$formule}}</strong>.</p>
    <p>Nous reviendrons vers vous dans les plus brefs délais pour vous fournir plus de détails et vous assister dans votre projet.</p>
    @include('emails.partials.confirmation_signature')
@endsection
