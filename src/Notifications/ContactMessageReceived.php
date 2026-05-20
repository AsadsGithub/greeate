<?php

namespace Greeate\Greeate\Notifications;

use Greeate\Greeate\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactMessageReceived extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public ContactMessage $message) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Contact Message: '.$this->message->subject)
            ->line('From: '.$this->message->name.' ('.$this->message->email.')')
            ->line($this->message->message)
            ->action('View in Admin', url('/'.config('greeate.admin_prefix').'/contact-messages/'.$this->message->id));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'contact_message_id' => $this->message->id,
            'name' => $this->message->name,
            'email' => $this->message->email,
        ];
    }
}
