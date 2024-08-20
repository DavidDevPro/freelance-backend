<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class MailService
{
  /**
   * Envoyer un email de contact.
   *
   * @param string $email L'adresse email du destinataire
   * @param string $message Le message de contact
   * @return void
   */
  public function sendContactEmail($email, $message)
  {
    $data = ['message' => $message];

    Mail::send('emails.contact', $data, function ($message) use ($email) {
      $message->to($email)
        ->subject('Contact Form Submission');
    });
  }
}
