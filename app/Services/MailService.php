<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Exception;

class MailService
{
    protected $adminEmail;

    public function __construct()
    {
        // Récupérer l'adresse email de l'administrateur à partir de la configuration
        $this->adminEmail = Config::get('mail.admin_email');

        if (empty($this->adminEmail)) {
            throw new Exception("L'adresse email de l'administrateur n'est pas configurée.");
        }
    }

    /**
     * Envoyer un email de confirmation au client pour la demande de contact.
     *
     * @param array $data Les données nécessaires pour l'email
     * @return void
     * @throws Exception
     */
    public function sendContactConfirmationEmail(array $data)
    {
        if (empty($data['email'])) {
            throw new Exception("L'adresse email du client est manquante.");
        }

        Mail::send('emails.contact_confirmation', $data, function ($message) use ($data) {
            $message->to($data['email'])
                    ->subject('Confirmation de votre demande de contact');
        });
    }

    /**
     * Envoyer un email de notification à l'administrateur avec les détails du contact soumis.
     *
     * @param array $data Les données de contact soumis
     * @return void
     * @throws Exception
     */
    public function sendContactNotificationEmail(array $data)
    {
        // Validation des clés nécessaires dans le tableau $data
        $requiredFields = ['from_name', 'email', 'phone', 'subject', 'namewebsite', 'userMessage'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                throw new Exception("Le champ $field est manquant ou vide.");
            }
        }

        // Envoi de l'email avec les données fournies
        Mail::send('emails.contact_notification', $data, function ($message) use ($data) {
            $message->to($this->adminEmail)
                    ->subject('Formulaire de contact de : ' . $data['from_name'])
                    ->replyTo($data['email'], $data['from_name']);
        });
    }

         /**
     * Envoyer une notification lors de l'ajout d'un témoignage.
     *
     * @param array $data Les données du témoignage soumis
     * @return void
     * @throws Exception
     */
    public function sendTestimonialNotificationEmail(array $data)
    {
        if (empty($data['firstName']) || empty($data['lastName'])) {
            throw new Exception("Le nom de l'auteur du témoignage est manquant.");
        }
    
        Mail::send('emails.testimonial_notification', $data, function ($message) use ($data) {
            $message->to($this->adminEmail)
                    ->subject('Nouveau témoignage ajouté par ' . $data['firstName'] . ' ' . $data['lastName']);
        });
    }

    /**
     * Envoyer un email de remerciement après la soumission d'un témoignage.
     *
     * @param array $data Les données nécessaires pour l'email
     * @return void
     * @throws Exception
     */
    public function sendTestimonialConfirmationEmail(array $data)
    {
        if (empty($data['email'])) {
            throw new Exception("L'adresse email du client est manquante.");
        }
    
        if (empty($data['firstName']) || empty($data['lastName'])) {
            throw new Exception("Le prénom ou le nom du client est manquant.");
        }
    
        Mail::send('emails.testimonial_confirmation', $data, function ($message) use ($data) {
            $message->to($data['email'])
                    ->subject('Merci pour votre témoignage, ' . $data['firstName'] . ' ' . $data['lastName'] . ' !');
        });
    }  

    /**
     * Envoyer un email de confirmation au client pour la demande de devis.
     *
     * @param array $data Les données nécessaires pour l'email
     * @return void
     * @throws Exception
     */
    public function sendProposalConfirmationEmail(array $data)
    {
        if (empty($data['email'])) {
            throw new Exception("L'adresse email du client est manquante.");
        }
    
        Mail::send('emails.proposal_confirmation', $data, function ($message) use ($data) {
            $message->to($data['email'])
                    ->subject('Confirmation de votre demande de devis');
        });
    }

    /**
     * Envoyer un email à l'administrateur avec les détails du devis.
     *
     * @param array $data Les données du devis soumis
     * @return void
     * @throws Exception
     */
    public function sendProposalNotificationEmail(array $data)
    {
        if (empty($data['firstName']) || empty($data['lastName'])) {
            throw new Exception("Les détails du client sont incomplets.");
        }
    
        Mail::send('emails.proposal_notification', $data, function ($message) use ($data) {
            $message->to($this->adminEmail)
                    ->subject('Nouvelle demande de devis de ' . $data['firstName'] . ' ' . $data['lastName']);
        });
    }

    /**
     * Envoyer un email de confirmation au client pour la création du compte 1/2.
     *
     * @param array $data Les données nécessaires pour l'email
     * @return void
     * @throws Exception
     */
    public function sendAccountConfirmationEmail(array $data)
    {
        if (empty($data['email'])) {
            throw new Exception("L'adresse email du client est manquante.");
        }
    
        Mail::send('emails.account_confirmation', $data, function ($message) use ($data) {
            $message->to($data['email'])
                    ->subject('Bienvenue ! Votre espace client a été créé avec succès sur ' . $data['namewebsite'] . ' (1/2)');
        });
    }

        /**
     * Envoyer un email avec le mot de passe.
     *
     * @param array $data Les données nécessaires pour l'email
     * @return void
     * @throws Exception
     */
    public function sendPasswordEmail(array $data)
    {
        if (empty($data['email'])) {
            throw new Exception("L'adresse email du client est manquante.");
        }

        Mail::send('emails.account_confirmation', $data, function ($message) use ($data) {
            $message->to($data['email'])
                    ->subject('Bienvenue ! Votre espace client a été créé avec succès sur ' . $data['namewebsite'] . ' (2/2)');
        });
    }

    /**
     * Envoyer un email de réinitialisation de mot de passe.
     *
     * @param array $data Les données nécessaires pour l'email
     * @return void
     * @throws Exception
     */
    public function sendPasswordResetEmail(array $data)
    {
        if (empty($data['email'])) {
            throw new Exception("L'adresse email du client est manquante.");
        }
    
        Mail::send('emails.password_reset', $data, function ($message) use ($data) {
            $message->to($data['email'])
                    ->subject('Réinitialisation de mot de passe');
        });
    }
}
