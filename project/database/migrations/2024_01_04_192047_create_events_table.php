<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->integer('total_seats')->nullable();
            $table->integer('available_seats')->nullable();
            $table->dateTime('departure_date_time');
            $table->dateTime('arrival_date_time');
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('tour_guide_id')
                ->nullable()
                ->constrained('tour_guides');

            $table->foreignId('vehicle_id')
                ->nullable()
                ->constrained('vehicles');

            $table->foreignId('tour_id')
                ->nullable()
                ->constrained('tours');

            $table->foreignId('driver_id')
                ->nullable()
                ->constrained('drivers');

            $table->foreignId('company_id')
                ->nullable()
                ->constrained('companies');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
