<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\Transaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentNotification extends Notification
{
    use Queueable;

    public $transaction;
    public $isSuccess;
    /**
     * Create a new notification instance.
     */
    public function __construct(Transaction $transaction, $isSuccess)
    {
        $this->transaction = $transaction;
        $this->isSuccess = $isSuccess;
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
     * Construire le message de notification pour le canal de mail.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if($this->isSuccess){
        return (new MailMessage)
                    ->subject('Votre paiement a été effectué')
                    ->greeting('Bonjour ' . $notifiable->name)
                    ->line('Votre paiement a été effectué avec succès.')
                    ->line('Merci pour votre confiance.');
        }else{
            return (new MailMessage)
                ->subject('Votre paiement a échoué')
                ->greeting('Bonjour ' . $notifiable->name)
                ->line('Votre paiement a échoué.')
                ->line('Merci pour votre confiance.');
        }
    }

    /**
     * Construire la représentation de la notification pour la base de données.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\DatabaseMessage|array
     */
    public function toDatabase($notifiable)
    {
        if($this->isSuccess){
        return [
            'transaction_id' => $this->transaction->id,
            'title' => 'Paiement effectué',
            'type' => 'success',
            'message'  => 'Votre paiement a été effectué avec succès.',
        ];
        }else{
            return [
                'transaction_id' => $this->transaction->id,
                'title' => 'Paiement échoué',
                'type' => 'error',
                'message'  => 'Votre paiement a échoué.',
            ];
        }
    }
}
