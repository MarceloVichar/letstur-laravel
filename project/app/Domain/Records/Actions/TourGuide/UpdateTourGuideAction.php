<?php

namespace App\Domain\Records\Actions\TourGuide;

use App\Domain\Records\Models\TourGuide;

class UpdateTourGuideAction
{
    public function execute(TourGuide $tourGuide, TourGuideData $data): TourGuide
    {
        $dataArray = array_keys_as($data->toArray(), [
            'companyId' => 'company_id',
        ]);

        return tap($tourGuide)
            ->update($dataArray);
    }
}
