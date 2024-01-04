<?php

namespace App\Domain\Records\Models;

use App\Domain\Account\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tour extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'round_trip',
        'price_cents',
        'note',
        'locale_id',
        'company_id',
        'tour_type_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function locale()
    {
        return $this->belongsTo(Locale::class);
    }

    public function tourType()
    {
        return $this->belongsTo(TourType::class);
    }
}
