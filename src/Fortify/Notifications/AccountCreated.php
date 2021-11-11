<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * @codeCoverageIgnore
 */
class AccountCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private string $password)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->line("The password for your account is **{$this->password}**.")
            ->action('Login', route('login'))
            ->line('Please delete this e-mail after logging in and storing the password.');
    }
}
