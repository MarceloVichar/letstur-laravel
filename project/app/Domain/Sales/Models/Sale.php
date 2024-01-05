<?php

namespace App\Domain\Sales\Models;

use App\Domain\Account\Models\Company;
use App\Domain\Account\Models\User;
use App\Domain\Events\Models\Event;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'total_value_cents',
        'status',
        'voucher',
        'company_id',
        'seller_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_document',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }

    public function events()  {
        return $this->belongsToMany(Event::class, 'events_sales', 'sale_id', 'event_id')
            ->withPivot('quantity', 'total_value_cents', 'passengers')
            ->withTimestamps();
    }

    public function eventsSales() : Collection
    {
        return $this->events()
            ->get([]);
    }
}
