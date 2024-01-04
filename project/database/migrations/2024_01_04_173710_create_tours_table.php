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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('round_trip');
            $table->integer('price_cents');
            $table->string('note')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('locale_id')
                ->nullable()
                ->constrained('locales');

            $table->foreignId('company_id')
                ->nullable()
                ->constrained('companies');

            $table->foreignId('tour_type_id')
                ->nullable()
                ->constrained('tour_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
