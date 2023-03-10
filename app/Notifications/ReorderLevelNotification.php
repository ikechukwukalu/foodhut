<?php

namespace App\Notifications;

use App\Models\Ingredient;
use App\Models\Merchant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReorderLevelNotification extends Notification
{
    use Queueable;

    private Merchant $merchant;
    private Ingredient $ingredient;

    /**
     * Create a new notification instance.
     *
     * @param App\Models\Merchant $merchant
     * @param App\Models\Ingredient $ingredient
     */
    public function __construct(Merchant $merchant, Ingredient $ingredient)
    {
        $this->merchant = $merchant;
        $this->ingredient = $ingredient;
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
        return (new MailMessage)
                     ->subject(trans('order.mail.subject'))
                    ->line(trans('order.mail.introduction', ['name' => $this->merchant->name]))
                    ->line(trans('order.mail.message', ['name' => $this->ingredient->name]))
                    ->action(trans('order.mail.action'), url('/'))
                    ->line(trans('order.mail.complimentary_close'));
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
