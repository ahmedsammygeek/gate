<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyAdminWithNewTransaction extends Notification
{
    use Queueable;

    public $transaction;

    /**
     * Create a new notification instance.
     */
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }



    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_transaction' , 
            'title' => 'عمليه دفع جديده' , 
            'content' => 'تم استقبال عمليه دفع جديده بقيمه '.$this->transaction->amount.' ريال ', 
            'url' => route('board.transactions.show' , $this->transaction->id ) , 
        ];
    }
}
