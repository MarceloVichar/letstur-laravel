<?php

namespace App\Domain\Records\Models;

use App\Domain\Account\Models\Company;
use Database\Factories\Domain\Records\Models\TourGuideFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourGuide extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'document',
        'phone',
        'email',
        'company_id',
    ];

    protected static function newFactory()
    {
        return TourGuideFactory::new();
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
