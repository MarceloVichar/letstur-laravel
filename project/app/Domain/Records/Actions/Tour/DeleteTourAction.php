<?php

namespace App\Domain\Records\Actions\Tour;

use App\Domain\Records\Models\Tour;

class DeleteTourAction
{
    public function execute(Tour $tour): bool
    {
        return $tour->delete();
    }
}
