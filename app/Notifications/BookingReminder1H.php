<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Models\Booking;
use Illuminate\Support\Facades\Log;

class BookingReminder1H extends Notification
{
    public function __construct(protected Booking $booking)
    {
    }
 
    public function via($notifiable): array
    {
        return ['mail'];
    }
 
    public function toMail($notifiable): MailMessage
    {
     
        Log::info('Notification sent:', ['user_id' => $notifiable->id, 'message' => '1 hour notifiacation has been send']);

        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }
 
    public function toArray($notifiable): array
    {
        return [];
    }
}