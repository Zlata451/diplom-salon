<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Назва послуги
            $table->text('description')->nullable(); // Опис (необов'язковий)
            $table->decimal('price', 8, 2); // Ціна
            $table->integer('duration'); // Тривалість у хвилинах
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
