<?php

namespace App\Domain\Records\Actions\TourType;

use App\Domain\Records\Models\TourType;

class CreateTourTypeAction
{
    public function execute(TourTypeData $data): TourType
    {
        $dataArray = array_keys_as($data->toArray(), [
            'companyId' => 'company_id',
            'isExclusive' => 'is_exclusive',
            'isTransfer' => 'is_transfer',
        ]);

        return app(TourType::class)
            ->create($dataArray);
    }
}
