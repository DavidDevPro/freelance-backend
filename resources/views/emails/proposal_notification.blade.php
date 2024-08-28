<!-- resources/views/emails/proposal_notification.blade.php -->
@extends('emails.layout')

@section('title', 'Nouvelle demande de devis reçue')

@section('content')
<p>Bonjour Fabrice,</p>

<p style="margin-bottom: 20px;">
    Vous avez reçu une nouvelle demande de devis. Voici les détails de la demande :
</p>

<table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
    <tr>
        <td style="padding: 8px; border: 1px solid #dddddd; background-color: #f9f9f9;">
            <strong style="color: #2283B6;">Nom :</strong>
        </td>
        <td style="padding: 8px; border: 1px solid #dddddd;">
            {{$fullName}}
        </td>
    </tr>
    <tr>
        <td style="padding: 8px; border: 1px solid #dddddd; background-color: #f9f9f9;">
            <strong style="color: #2283B6;">Formule choisie :</strong>
        </td>
        <td style="padding: 8px; border: 1px solid #dddddd;">
            {{$formule}}
        </td>
    </tr>
    <tr>
        <td style="padding: 8px; border: 1px solid #dddddd; background-color: #f9f9f9;">
            <strong style="color: #2283B6;">Options supplémentaires :</strong>
        </td>
        <td style="padding: 8px; border: 1px solid #dddddd;">
            @if(!empty($options))
                <ul>
                    @foreach($options as $option)
                        <li>{{$option}}</li>
                    @endforeach
                </ul>
            @else
                Aucune option supplémentaire sélectionnée.
            @endif
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
            <strong style="color: #2283B6;">Numéro de téléphone :</strong>
        </td>
        <td style="padding: 8px; border: 1px solid #dddddd;">
            {{$phone ?? 'Non spécifié'}}
        </td>
    </tr>
    <tr>
        <td style="padding: 8px; border: 1px solid #dddddd; background-color: #f9f9f9;">
            <strong style="color: #2283B6;">Adresse :</strong>
        </td>
        <td style="padding: 8px; border: 1px solid #dddddd;">
            {{$address ?? 'Non spécifiée'}}
        </td>
    </tr>
    <tr>
        <td style="padding: 8px; border: 1px solid #dddddd; background-color: #f9f9f9;">
            <strong style="color: #2283B6;">Code Postal :</strong>
        </td>
        <td style="padding: 8px; border: 1px solid #dddddd;">
            {{$postalCode ?? 'Non spécifié'}}
        </td>
    </tr>
    <tr>
        <td style="padding: 8px; border: 1px solid #dddddd; background-color: #f9f9f9;">
            <strong style="color: #2283B6;">Ville :</strong>
        </td>
        <td style="padding: 8px; border: 1px solid #dddddd;">
            {{$city ?? 'Non spécifiée'}}
        </td>
    </tr>
    <tr>
        <td style="padding: 8px; border: 1px solid #dddddd; background-color: #f9f9f9;">
            <strong style="color: #2283B6;">Informations supplémentaires :</strong>
        </td>
        <td style="padding: 8px; border: 1px solid #dddddd;">
            {{$supplementalInfo ?? 'Aucune information supplémentaire fournie'}}
        </td>
    </tr>
</table>

@include('emails.partials.notification_signature')
@endsection
