<?php

namespace App\Domain\Events\Actions\Event;

use App\Domain\Events\Models\Event;

class DeleteEventAction
{
    public function execute(Event $event): bool
    {
        return $event->delete();
    }
}
