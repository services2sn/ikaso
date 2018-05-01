<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AccountCreated extends Notification
{
    use Queueable;

    private $activationCode;
    private $isReturn; 

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($activationCode, $isReturn = false)
    {
        $this->activationCode = $activationCode;
        $this->isReturn = $isReturn;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('/account/activate/'. $this->activationCode);
        return (new MailMessage)
                    ->subject("Votre compte IKASO est cree")
                    ->greeting('Bonjour')
                    ->line('Vous venez de creer un compte sur IKASO. Nous vous souhaitons la bienvenue.')
                    ->line("Maintenant, il ne vous reste plus qu'a activer votre compte.")
                    ->line("Et pour cela rien de plus simpe, cliquer juste sur le bouton ci-dessous.")
                    ->action('Activer mon compte', $url)
                    ->line('Merci pour votre confiance !')
                    ->line('Equipe IKASO');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
