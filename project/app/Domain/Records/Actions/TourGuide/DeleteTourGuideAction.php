<?php

namespace App\Domain\Records\Actions\TourGuide;

use App\Domain\Records\Models\TourGuide;

class DeleteTourGuideAction
{
    public function execute(TourGuide $tourGuide): bool
    {
        return $tourGuide->delete();
    }
}
