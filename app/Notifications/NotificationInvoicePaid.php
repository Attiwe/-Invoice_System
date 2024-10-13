<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificationInvoicePaid extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private $invoices_id; 
    
    public function __construct($invoices_id)
    {
        $this->invoices_id= $invoices_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = 'http://127.0.0.1:8000/InvoiceController/'.$this->invoices_id;
        return (new MailMessage)
                    ->subject('The introduction to the notification.')
                    ->action('Notification Action',  $url)
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
