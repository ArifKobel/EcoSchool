<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends Notification
{

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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
    public function toMail(object $notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject(Lang::get('E-Mail-Adresse bestätigen - EcoSchool'))
            ->view('vendor.mail.html.message', [
                'greeting' => 'Hallo!',
                'introLines' => [
                    'Bitte klicken Sie auf den Button unten, um Ihre E-Mail-Adresse zu bestätigen.'
                ],
                'actionText' => Lang::get('auth.verify_email_address'),
                'actionUrl' => $verificationUrl,
                'outroLines' => [
                    'Falls Sie kein Konto erstellt haben, sind keine weiteren Schritte erforderlich.'
                ],
                'salutation' => 'Mit freundlichen Grüßen, das EcoSchool Team'
            ])
            ->text('vendor.mail.text.message', [
                'greeting' => 'Hallo!',
                'introLines' => [
                    'Bitte klicken Sie auf den Button unten, um Ihre E-Mail-Adresse zu bestätigen.'
                ],
                'actionText' => Lang::get('auth.verify_email_address'),
                'actionUrl' => $verificationUrl,
                'outroLines' => [
                    'Falls Sie kein Konto erstellt haben, sind keine weiteren Schritte erforderlich.'
                ],
                'salutation' => 'Mit freundlichen Grüßen, das EcoSchool Team'
            ])
            ->from(config('mail.from.address'), config('mail.from.name'));
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

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
