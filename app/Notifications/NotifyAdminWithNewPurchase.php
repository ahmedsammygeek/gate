<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyAdminWithNewPurchase extends Notification
{
    use Queueable;

    public $purchase;

    /**
     * Create a new notification instance.
     */
    public function __construct($purchase)
    {
        $this->purchase = $purchase;
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
            'type' => 'purchase' , 
            'title' => 'عمليه شراء جديده ' , 
            'content' => 'لقد تمت عمليه شراء جديده برقم : '.$this->purchase->purchase_number.' بمبلغ : '.$this->purchase->total, 
            'url'  => route('board.purchases.show' , $this->purchase->id ) ,
        ];  
    }
}
