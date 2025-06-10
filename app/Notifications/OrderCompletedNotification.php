<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderCompletedNotification extends Notification
{
    use Queueable;

    public $order;

    /**
     * Crée une nouvelle instance de notification.
     *
     * @param \App\Models\Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Détermine les canaux par lesquels la notification sera envoyée.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Construction du message pour le canal mail.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Votre commande est terminée')
                    ->greeting('Bonjour ' . $notifiable->name)
                    ->line('Votre commande n°' . $this->order->id . ' a été complétée avec succès.')
                    ->action('Voir la commande', url('/orders/' . $this->order->id))
                    ->line('Merci d\'avoir utilisé notre service. Nous espérons que tout s\'est bien passé !');
    }

    /**
     * Construction de la représentation de la notification pour la base de données.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'title' => 'Commande est terminée',
            'type' => 'success',
            'message' => 'Votre commande a été complétée avec succès.'
        ];
    }
}
