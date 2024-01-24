<?php

namespace App\Domain\Records\Models;

use App\Domain\Account\Models\Company;
use Database\Factories\Domain\Records\Models\TourTypeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'is_exclusive',
        'is_transfer',
        'color',
        'company_id',
    ];

    protected static function newFactory()
    {
        return TourTypeFactory::new();
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
