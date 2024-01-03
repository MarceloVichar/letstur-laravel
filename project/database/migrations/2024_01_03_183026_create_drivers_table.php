<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cnh');
            $table->string('cnh_type');
            $table->string('document')->nullable();
            $table->string('phone');
            $table->date('date_of_birth');
            $table->string('email');
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
        Schema::dropIfExists('drivers');
    }
};
