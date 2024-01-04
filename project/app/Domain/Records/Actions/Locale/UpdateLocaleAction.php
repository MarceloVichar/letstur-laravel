<?php

namespace App\Domain\Records\Actions\Locale;

use App\Domain\Records\Models\Locale;

class UpdateLocaleAction
{
    public function execute(Locale $locale, LocaleData $data): Locale
    {
        $dataArray = array_keys_as($data->toArray(), [
            'cnhType' => 'cnh_type',
            'dateOfBirth' => 'date_of_birth',
            'companyId' => 'company_id',
        ]);

        return tap($locale)
            ->update($dataArray);
    }
}
