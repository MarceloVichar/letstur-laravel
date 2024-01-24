<?php

namespace App\Domain\Records\Actions\TourType;

use App\Domain\Records\Models\TourType;

class DeleteTourTypeAction
{
    public function execute(TourType $tourType): bool
    {
        return $tourType->delete();
    }
}
