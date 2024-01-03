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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('license_plate');
            $table->string('type');
            $table->string('model');
            $table->integer('number_of_seats');
            $table->string('cnh_type_required');
            $table->string('owner_name');
            $table->string('owner_document');
            $table->string('owner_phone');
            $table->string('owner_email');
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
        Schema::dropIfExists('vehicles');
    }
};
