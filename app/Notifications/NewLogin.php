<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Stevebauman\Location\Facades\Location;

class NewLogin extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function toMail($notifiable): MailMessage
    {
        $tokenName = request()?->get('browser_id');
        $invalidateTokenUrl = route("invalidate", ['token' => $tokenName]);

        $userIp = request()?->ip();
        $locationData = Location::get($userIp);
        $location = "Location: unavailable";
        if($locationData){
            $location = "Location: " . $locationData->countryName . ", " . $locationData->cityName;
        }
        return (new MailMessage)
            ->greeting('New Sign-in')
            ->line("Your account is at risk if this wasn't you.")
            ->line($location)
            ->line("IP address: $userIp")
            ->action('Secure my account', $invalidateTokenUrl)
            ->salutation('Regards');
    }
}
