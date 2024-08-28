<?php

namespace App\Helpers;

class EmailHelper
{
    public static function sendEmail($mailService, $template, $data)
    {
        switch ($template) {
            // Cas pour l'envoi d'email de confirmation de contact
            case 'contact_confirmation':
                $confirmationData = [
                    'email' => $data['email'],
                    'from_name' => $data['firstName'] . ' ' . $data['lastName'],
                ];
                $mailService->sendContactConfirmationEmail($confirmationData);
                break;
            
                // Cas pour l'envoi d'email de notification de contact
            case 'contact_notification':
                $notificationData = [
                    'from_name' => $data['firstName'] . ' ' . $data['lastName'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'subject' => $data['subject'],
                    'namewebsite' => $data['namewebsite'],
                    'userMessage' => $data['message'],
                ];
                $mailService->sendContactNotificationEmail($notificationData);
                break;
            
            // Cas pour l'envoi d'email de confirmation de témoignage
            case 'testimonial_confirmation':
                $confirmationData = [
                    'email' => $data['email'], 
                    'firstName' => $data['firstName'],
                    'lastName' => $data['lastName'],
                ];
                $mailService->sendTestimonialConfirmationEmail($confirmationData);
                break;

            // Cas pour l'envoi d'email de notification de témoignage
            case 'testimonial_notification':
                $notificationData = [
                    'firstName' => $data['firstName'],
                    'lastName' => $data['lastName'],
                    'email' => $data['email'],
                    'role' => $data['role'],
                    'comment' => $data['comment'],
                    'source' => $data['source'] ?? null,
                ];
                $mailService->sendTestimonialNotificationEmail($notificationData);
                break;

            // Cas pour l'envoi d'email de confirmation de proposition
            case 'proposal_confirmation':
                $confirmationData = [
                    'email' => $data['email'],
                    'fullName' => trim($data['civility'] . ' ' . $data['firstName'] . ' ' . $data['lastName']),
                    'formule' => $data['formule'],
                ];
                $mailService->sendProposalConfirmationEmail($confirmationData);
                break;

            // Cas pour l'envoi d'email de notification de proposition
            case 'proposal_notification':
                $notificationData = [
                    'firstName' => $data['firstName'] ?? null,
                    'lastName' => $data['lastName'] ?? null,
                    'fullName' => trim(($data['civility'] ?? '') . ' ' . ($data['firstName'] ?? '') . ' ' . ($data['lastName'] ?? '')),
                    'formule' => $data['formule'],
                    'options' => $data['options'] ?? [],
                    'email' => $data['email'],
                    'phone' => $data['phone'] ?? null,
                    'address' => $data['address'] ?? null,
                    'postalCode' => $data['postalCode'] ?? null,
                    'city' => $data['city'] ?? null,
                    'supplementalInfo' => $data['supplementalInfo'] ?? 'Aucune information supplémentaire fournie',
                ];
                $mailService->sendProposalNotificationEmail($notificationData);
                break;
            
            // Cas pour l'envoi d'email de confirmation de création de compte
            case 'account_confirmation':
                $confirmationData = [
                    'email' => $data['email'],
                    'fullName' => trim(($data['civility'] ?? '') . ' ' . ($data['firstName'] ?? '') . ' ' . ($data['lastName'] ?? '')),
                    'username' => $data['username'],
                    'namewebsite' => $data['namewebsite'],
                    'linkwebsite'=> $data['linkwebsite']
                ];
                $mailService->sendAccountConfirmationEmail($confirmationData);
                break;
            // Cas pour l'envoi d'email de confirmation de mot de passe à la création de compte
            case 'password_confirmation':
                $confirmationData = [
                    'email' => $data['email'],
                    'fullName' => trim(($data['civility'] ?? '') . ' ' . ($data['firstName'] ?? '') . ' ' . ($data['lastName'] ?? '')),
                    'username' => $data['username'],
                    'namewebsite' => $data['namewebsite'],
                    'password'=> $data['password']
                ];
                $mailService->sendPasswordConfirmationEmail($confirmationData);
                break;
            // Cas pour l'envoi d'email de confirmation de mot de passe oublié
            case 'password_reset_confirmation':
                $confirmationData = [
                    'email' => $data['email'],
                    'fullName' => trim(($data['civility'] ?? '') . ' ' . ($data['firstName'] ?? '') . ' ' . ($data['lastName'] ?? '')),
                    'username' => $data['username'],
                    'namewebsite' => $data['namewebsite'],
                    '$resetUrl'=> $data['reset_link']
                ];
                $mailService->sendPasswordResetConfirmationEmail($confirmationData);
                break;
        }
    }
}