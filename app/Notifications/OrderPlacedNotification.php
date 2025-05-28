<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class OrderPlacedNotification extends Notification
{
    use Queueable;
    
    public $order;

    /**
     * Crée une nouvelle instance de notification.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Détermine les canaux de notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // On utilise ici le canal de mail et celui de la base de données
        return ['mail', 'database'];
    }

    /**
     * Construire le message de notification pour le canal de mail.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Votre commande a été reçue')
                    ->greeting('Bonjour ' . $notifiable->name)
                    ->line('Votre commande numéro ' . $this->order->id . ' a été enregistrée avec succès.')
                    ->action('Voir la commande', url('/orders/' . $this->order->id))
                    ->line('Merci pour votre confiance.');
    }

    /**
     * Construire la représentation de la notification pour la base de données.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\DatabaseMessage|array
     */
    public function toDatabase($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'title' => 'Commande a été reçue',
            'type' => 'success',
            'message'  => 'Votre commande a été enregistrée avec succès.',
        ];
    }
}
