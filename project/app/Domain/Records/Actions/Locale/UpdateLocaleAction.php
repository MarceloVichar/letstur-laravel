<?php

namespace App\Domain\Records\Actions\Locale;

use App\Domain\Records\Models\Locale;

class UpdateLocaleAction
{
    public function execute(Locale $locale, LocaleData $data): Locale
    {
        $dataArray = array_keys_as($data->toArray(), [
            'zipCode' => 'zip_code',
            'responsibleName' => 'responsible_name',
            'responsiblePhone' => 'responsible_phone',
            'companyId' => 'company_id',
        ]);

        return tap($locale)
            ->update($dataArray);
    }
}
