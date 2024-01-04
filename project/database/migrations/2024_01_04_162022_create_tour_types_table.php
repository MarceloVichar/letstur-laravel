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
        Schema::create('tour_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_transfer');
            $table->boolean('is_exclusive');
            $table->string('color')->nullable();
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('tour_types');
    }
};
