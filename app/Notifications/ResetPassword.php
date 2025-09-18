<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class ResetPassword extends Notification
{

    public $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
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
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject(Lang::get('Passwort zurücksetzen - EcoSchool'))
            ->view('vendor.mail.html.message', [
                'greeting' => 'Hallo!',
                'introLines' => [
                    'Sie erhalten diese E-Mail, weil wir eine Anfrage zum Zurücksetzen des Passworts für Ihr Konto erhalten haben.'
                ],
                'actionText' => Lang::get('Passwort zurücksetzen'),
                'actionUrl' => $url,
                'outroLines' => [
                    'Dieser Link zum Zurücksetzen des Passworts läuft in '.config('auth.passwords.'.config('auth.defaults.passwords').'.expire').' Minuten ab.',
                    'Falls Sie keine Passwort-Zurücksetzung angefordert haben, sind keine weiteren Schritte erforderlich.'
                ],
                'salutation' => 'Mit freundlichen Grüßen, das EcoSchool Team'
            ])
            ->text('vendor.mail.text.message', [
                'greeting' => 'Hallo!',
                'introLines' => [
                    'Sie erhalten diese E-Mail, weil wir eine Anfrage zum Zurücksetzen des Passworts für Ihr Konto erhalten haben.'
                ],
                'actionText' => Lang::get('Passwort zurücksetzen'),
                'actionUrl' => $url,
                'outroLines' => [
                    'Dieser Link zum Zurücksetzen des Passworts läuft in '.config('auth.passwords.'.config('auth.defaults.passwords').'.expire').' Minuten ab.',
                    'Falls Sie keine Passwort-Zurücksetzung angefordert haben, sind keine weiteren Schritte erforderlich.'
                ],
                'salutation' => 'Mit freundlichen Grüßen, das EcoSchool Team'
            ]);
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
