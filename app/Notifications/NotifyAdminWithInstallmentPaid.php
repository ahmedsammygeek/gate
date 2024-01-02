<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyAdminWithInstallmentPaid extends Notification
{
    use Queueable;
    public $installment;

    /**
     * Create a new notification instance.
     */
    public function __construct($installment)
    {
        $this->installment = $installment;
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
            'type' => 'piad_installment' , 
            'title' => 'سداد قسط جديد' , 
            'content' => 'تم تسديد القسط رقم .'.$this->installment->installment_number.' بملغ قيمته '.$this->installment->amount, 
            'url' => route('board.installments.show' , $this->installment->id ) , 
        ];
    }
}
