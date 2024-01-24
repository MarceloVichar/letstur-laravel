<?php

namespace App\Domain\Records\Models;

use App\Domain\Account\Models\Company;
use Database\Factories\Domain\Records\Models\LocaleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Locale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'zip_code',
        'street',
        'number',
        'complement',
        'district',
        'city',
        'uf',
        'responsible_name',
        'responsible_phone',
        'company_id',
    ];

    protected static function newFactory()
    {
        return LocaleFactory::new();
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
