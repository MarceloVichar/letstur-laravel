<?php

namespace App\Domain\Records\Actions\Driver;

use App\Domain\Records\Models\Driver;

class DeleteDriverAction
{
    public function execute(Driver $driver): bool
    {
        return $driver->delete();
    }
}
