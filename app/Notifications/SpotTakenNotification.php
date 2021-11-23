<?php

namespace App\Notifications;

use App\Models\Availability;
use App\Models\Connector;
use App\Models\LocationSubscriber;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class SpotTakenNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $available;
    private $plugType;

    public $backoff = 30;
    public $tries = 5;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Availability $available, $plugType, LocationSubscriber $locationSubscriber)
    {
        $this->available = $available;
        $this->plugType = $plugType;
        $this->locationSubscriber = $locationSubscriber;
        $this->locationSubscriber->refreshUuid();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        Log::info(class_basename(__CLASS__) . ' to ' . $notifiable->email . ' ' . $this->available->location->name . ' ' . $this->plugType);
        return (new MailMessage)
                    ->line('A spot got taken at ' . $this->available->location->name . '.')
                    ->line($this->available->location->line1 . ' ' . $this->available->location->line2)
                    ->line('Total spots of type ' . Connector::getPlugType($this->plugType) . " " . $this->available->getSpotsByPlugType($this->plugType))
                    ->action('Go to subscriptions', url('/subscriptions'))
                    ->line('Thank you for using our application!');
    }

    public function toTelegram($notifiable)
    {
        Log::info(class_basename(__CLASS__) . ' to ' . $notifiable->email . ' ' . $this->available->location->name . ' ' . $this->plugType);
        return TelegramMessage::create()
            // Optional recipient user id.
            ->to($notifiable->telegram_user_id)
            // Markdown supported.
            ->content(
                $this->available->getSpotsByPlugType($this->plugType) // amout of spots
                    . ' spots of type ' . Connector::getPlugType($this->plugType)
                    . ' available at ' . $this->available->location->name . '.' .
                    "\nSpot taken!"
            )
            ->button('Directions', route('home'))
            ->button('Unsubscribe', route('unsubsribe', $this->locationSubscriber));
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
