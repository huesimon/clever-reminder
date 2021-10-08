<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Mockery\Generator\StringManipulation\Pass\AvoidMethodClashPass;
use Symfony\Component\Translation\PseudoLocalizationTranslator;

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
                    ->line("There are currently $this->availableSpots at $this->locationName")
                    ->action('Notification Action', url('/'))
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
