<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AdValidatedNotification extends Notification
{
    use Queueable;

    protected $ad;

    /**
     * Crée une nouvelle instance de notification.
     *
     * @param mixed $ad L'annonce validée
     */
    public function __construct($ad)
    {
        $this->ad = $ad;
    }

    /**
     * Détermine les canaux par lesquels la notification sera envoyée.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // On utilise à la fois le canal mail et le canal de la base de données
        return ['mail', 'database'];
    }

    /**
     * Construire le message pour le canal mail.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Votre annonce est validée')
                    ->greeting('Bonjour ' . $notifiable->name)
                    ->line("Votre annonce intitulée '{$this->ad->title}' a été validée.")
                    ->action('Voir l\'annonce', url('/ads/' . $this->ad->id))
                    ->line('Merci de nous faire confiance !');
    }

    /**
     * Construire la représentation de la notification pour la base de données.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'ad_id'   => $this->ad->id,
            'title' => 'Annonce a été validée',
            'type' => 'success',
            'message' => 'Votre annonce a été validée.',
        ];
    }
}
