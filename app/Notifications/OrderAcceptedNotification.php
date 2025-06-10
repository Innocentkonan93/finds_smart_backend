<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderAcceptedNotification extends Notification
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
     * Construct le message pour le canal mail.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Votre commande a été acceptée')
                    ->greeting('Bonjour ' . $notifiable->name)
                    ->line('Nous avons le plaisir de vous informer que votre commande numéro ' . $this->order->id . ' a été acceptée par le professionnel.')
                    ->action('Voir la commande', url('/orders/' . $this->order->id))
                    ->line('Merci d\'utiliser notre service et à bientôt !');
    }

    /**
     * Renvoie les données de la notification pour la sauvegarde dans la base de données.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'title' => 'Commande a été acceptée',
            'type' => 'success',
            'message'  => 'Votre commande a été acceptée par le professionnel.',
        ];
    }
}
