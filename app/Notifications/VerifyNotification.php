<?php

namespace App\Notifications;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $mail = config('constants.mail')['register'];

        $data = [
            'url' => $this->verificationUrl($notifiable),
            'user' => $notifiable->email,
            'expire_time' => 1
        ];

        return (new MailMessage)
            ->view('emails.auth.register', ['data' => $data])
            ->subject($mail['subject'])
            ->cc('support@example.com');
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

    public function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify', Carbon::now()->addMinutes(60), ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification()),]
        );
    }
}
