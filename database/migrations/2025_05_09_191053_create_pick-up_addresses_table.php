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
        Schema::create('pick-up_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('street');
            $table->string('house_number');
            $table->string('addition')->nullable();
            $table->string('postal_code');
            $table->string('city');
            $table->boolean('is_active')->default(true);
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pick-up_addresses');
    }
};
