<?php

namespace App\Domain\Records\Actions\Tour;

use App\Domain\Records\Models\Tour;

class UpdateTourAction
{
    public function execute(Tour $tour, TourData $data): Tour
    {
        $dataArray = array_keys_as($data->toArray(), [
            'companyId' => 'company_id',
            'localeId' => 'locale_id',
            'tourTypeId' => 'tour_type_id',
            'roundTrip' => 'round_trip',
            'priceCents' => 'price_cents',
        ]);

        return tap($tour)
            ->update($dataArray);
    }
}
