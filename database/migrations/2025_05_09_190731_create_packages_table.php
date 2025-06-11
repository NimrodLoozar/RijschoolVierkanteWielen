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
        // In deze migration wordt alleen de tabelstructuur aangemaakt, geen data toegevoegd.
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('type', 32);
            $table->integer('lesson_count');
            $table->decimal('price_per_lesson', 8, 2);
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
        Schema::dropIfExists('packages');
    }
};
