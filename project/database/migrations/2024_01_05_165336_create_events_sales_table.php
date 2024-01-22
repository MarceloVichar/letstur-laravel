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
        Schema::create('events_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')
                ->nullable()
                ->constrained('events');
            $table->foreignId('sale_id')
                ->nullable()
                ->constrained('sales');
            $table->integer('quantity');
            $table->integer('total_value_cents');
            $table->jsonb('passengers')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events_sales');
    }
};
