<?php

namespace App\Domain\Records\Actions\Locale;

use App\Domain\Records\Models\Locale;

class CreateLocaleAction
{
    public function execute(LocaleData $data): Locale
    {
        $dataArray = array_keys_as($data->toArray(), [
            'companyId' => 'company_id',
            'zipCode' => 'zip_code',
            'responsibleName' => 'responsible_name',
            'responsiblePhone' => 'responsible_phone',
        ]);

        $locale = app(Locale::class)
            ->create($dataArray);

        return $locale;
    }
}
