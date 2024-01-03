<?php

namespace App\Domain\Records\Models;

use App\Domain\Account\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'cnh',
        'cnh_type',
        'document',
        'phone',
        'date_of_birth',
        'email',
        'company_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
