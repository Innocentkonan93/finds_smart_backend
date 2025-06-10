<?php

namespace App\Notifications;

use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewServiceNotification extends Notification
{
    use Queueable;

    public $service;
    /**
     * Create a new notification instance.
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
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
            ->subject('Nouveau service')
            ->greeting('Bonjour ' . $notifiable->name)
            ->line('Votre service a été créé avec succès')
            ->action('Voir le service', url('/services/' . $this->service->id))
            ->line('Merci d\'utiliser notre service et à bientôt !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'service_id' => $this->service->id,
            'title' => 'Nouveau service',
            'message' => 'Votre nouveau service a été créé',
            'notification_type' => 'info'
        ];
    }
}
