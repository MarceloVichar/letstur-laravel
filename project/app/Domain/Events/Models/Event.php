<?php

namespace App\Domain\Events\Models;

use App\Domain\Account\Models\Company;
use App\Domain\Records\Models\Driver;
use App\Domain\Records\Models\Tour;
use App\Domain\Records\Models\TourGuide;
use App\Domain\Records\Models\Vehicle;
use App\Domain\Sales\Models\Sale;
use Database\Factories\Domain\Events\Models\EventFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'total_seats',
        'available_seats',
        'departure_date_time',
        'arrival_date_time',
        'tour_guide_id',
        'vehicle_id',
        'tour_id',
        'driver_id',
        'company_id',
    ];

    protected static function newFactory()
    {
        return EventFactory::new();
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function tourGuide()
    {
        return $this->belongsTo(TourGuide::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'events_sales', 'event_id', 'sale_id')
            ->withPivot('quantity', 'total_value_cents', 'passengers')
            ->withTimestamps();
    }
}
