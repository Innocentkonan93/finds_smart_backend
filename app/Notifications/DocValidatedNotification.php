<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocValidatedNotification extends Notification
{
    use Queueable;

    protected $document;
    /**
     * Create a new notification instance.
     */
    public function __construct($document)
    {
        $this->document = $document;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('Le document ' . $this->document->type . ' a été validé.')
            ->line('Merci de nous faire confiance!');
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
            'document_id'   => $this->document->id,
            'title' => 'Document ' . $this->document->type . ' validé',
            'type' => 'success',
            'message' => 'Votre document a été validé.',
        ];
    }
}
