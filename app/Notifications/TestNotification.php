<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Channels\Messages\WhatsAppMessage;
use App\Channels\WhatsAppChannel;
class TestNotification extends Notification
{
    use Queueable;
    public $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function via($notifiable)
    {
        return [WhatsAppChannel::class];
    }

    public function toWhatsApp($notifiable)
    {
        return (new WhatsAppMessage)
        ->content("*".$this->code."* is your verification code. For your security, do not share this code.");
    }
}
