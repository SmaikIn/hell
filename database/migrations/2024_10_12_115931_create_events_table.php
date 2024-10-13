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
        Schema::create('events', function (Blueprint $table) {
            $table->id(); // Уникальный идентификатор события
            $table->string('title'); // Название события
            $table->string('color'); // Цвет события
            $table->text('description')->nullable(); // Описание события
            $table->dateTime('start_time'); // Время начала события
            $table->dateTime('end_time'); // Время окончания события
            $table->timestamps(); // Метки времени для created_at и updated_at
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
