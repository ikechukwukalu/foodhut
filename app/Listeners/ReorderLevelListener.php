<?php

namespace App\Listeners;

use App\Events\ReorderLevel;
use App\Models\ReorderNotification;
use App\Models\Merchant;
use App\Notifications\ReorderLevelNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ReorderLevelListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\ReorderLevel $event
     */
    public function handle(ReorderLevel $event): void
    {
        if ($event->ingredient->isMerchantNotifiedForReorder($event))
        {
            return;
        }

        if (!$event->ingredient->isDueForReorder()) {
            return;
        }

        ReorderNotification::create([
            'user_id' => $event->ingredient->user_id,
            'ingredient_id' => $event->ingredient->id,
            'quantity_left' => $event->ingredient->quantity_available,
            'last_reorder_at' => $event->ingredient->last_reorder_at
        ]);

        if ($user = Merchant::find($event->ingredient->user_id)) {
            $user->notify(new ReorderLevelNotification($user, $event->ingredient));
        }
    }
}
