<?php

namespace App\Notifications;

use App\Models\Availability;
use App\Models\Connector;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SpotAvailableNotification extends Notification
{
    use Queueable;

    private $availability;
    private $plugType;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Availability $available, $plugType)
    {
        $this->available = $available;
        $this->plugType = $plugType;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('There is now a new spot available at ' . $this->available->location->name . '.')
                    ->line($this->available->location->line1 . ' ' . $this->available->location->line2)
                    ->line('Total spots of type ' . Connector::getPlugType($this->plugType) . " " . $this->available->getSpotsByPlugType($this->plugType))
                    ->action('Go to subscriptions', url('/subscriptions'))
                    ->line($this->plugType)
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
