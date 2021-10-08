<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Telegram\TelegramMessage;
use Symfony\Component\Translation\PseudoLocalizationTranslator;
use Mockery\Generator\StringManipulation\Pass\AvoidMethodClashPass;

class ChargePointSpotsAvailable extends Notification
{
    use Queueable;

    private $availableSpots;
    private $locationName;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($availableSpots, $locationName)
    {
        $this->availableSpots = $availableSpots;
        $this->locationName = $locationName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'telegram'];
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
                    ->line("There are currently $this->availableSpots at $this->locationName")
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toTelegram($notifiable)
    {
           return TelegramMessage::create()
            // Optional recipient user id.
            ->to($notifiable->telegram_user_id)
            // Markdown supported.
            ->content("Free: $this->availableSpots at $this->locationName");
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
