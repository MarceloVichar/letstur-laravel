<?php

namespace App\Domain\Records\Actions\TourGuide;

use App\Domain\Records\Models\TourGuide;

class CreateTourGuideAction
{
    public function execute(TourGuideData $data): TourGuide
    {
        $dataArray = array_keys_as($data->toArray(), [
            'companyId' => 'company_id',
        ]);

        $tourGuide = app(TourGuide::class)
            ->create($dataArray);

        return $tourGuide;
    }
}
