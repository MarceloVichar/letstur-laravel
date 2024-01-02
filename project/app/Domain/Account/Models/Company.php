<?php

namespace App\Domain\Account\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'trading_name',
        'cnpj',
        'ie',
        'phone',
        'secondary_phone',
        'email',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
