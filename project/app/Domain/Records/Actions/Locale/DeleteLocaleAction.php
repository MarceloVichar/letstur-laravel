<?php

namespace App\Domain\Records\Actions\Locale;

use App\Domain\Records\Models\Locale;

class DeleteLocaleAction
{
    public function execute(Locale $locale): bool
    {
        return $locale->delete();
    }
}
