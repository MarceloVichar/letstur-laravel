<?php

namespace App\Domain\Records\Models;

use App\Domain\Account\Models\Company;
use Database\Factories\Domain\Records\Models\VehicleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'license_plate',
        'type',
        'model',
        'number_of_seats',
        'cnh_type_required',
        'owner_name',
        'owner_document',
        'owner_phone',
        'owner_email',
        'company_id',
    ];

    protected static function newFactory()
    {
        return VehicleFactory::new();
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
