<!-- resources/views/emails/testimonial_notification.blade.php -->
@extends('emails.layout')

@section('title', 'Nouveau Témoignage Reçu')

@section('content')
<p>Bonjour,</p>
<p>Un nouveau témoignage a été ajouté par <strong>{{ $firstName }} {{ $lastName }}</strong> ({{ $role }}).</p>

<table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
    <tr>
        <td style="padding: 8px; border: 1px solid #dddddd; background-color: #f9f9f9;">
            <strong style="color: #2283B6;">Nom :</strong>
        </td>
        <td style="padding: 8px; border: 1px solid #dddddd;">
            {{ $firstName }} {{ $lastName }}
        </td>
    </tr>
    <tr>
        <td style="padding: 8px; border: 1px solid #dddddd; background-color: #f9f9f9;">
            <strong style="color: #2283B6;">Rôle :</strong>
        </td>
        <td style="padding: 8px; border: 1px solid #dddddd;">
            {{ $role }}
        </td>
    </tr>
    <tr>
        <td style="padding: 8px; border: 1px solid #dddddd; background-color: #f9f9f9;">
            <strong style="color: #2283B6;">Email de contact :</strong>
        </td>
        <td style="padding: 8px; border: 1px solid #dddddd;">
            <a href="mailto:{{$email}}" style="color: #2283B6;">{{$email}}</a>
        </td>
    </tr>
    <tr>
        <td style="padding: 8px; border: 1px solid #dddddd; background-color: #f9f9f9;">
            <strong style="color: #2283B6;">Commentaire :</strong>
        </td>
        <td style="padding: 8px; border: 1px solid #dddddd;">
            {{ $comment }}
        </td>
    </tr>
    @if(isset($source))
    <tr>
        <td style="padding: 8px; border: 1px solid #dddddd; background-color: #f9f9f9;">
            <strong style="color: #2283B6;">Source :</strong>
        </td>
        <td style="padding: 8px; border: 1px solid #dddddd;">
            {{ $source }}
        </td>
    </tr>
    @endif
</table>

@include('emails.partials.notification_signature')
@endsection
