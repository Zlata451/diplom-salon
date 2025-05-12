<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Клієнт
            $table->foreignId('master_id')->constrained('masters')->onDelete('cascade'); // Майстер
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade'); // Послуга

            $table->date('date');       // Дата запису
            $table->time('time');       // Час запису

            $table->string('status')->default('заплановано'); // Статус (заплановано, скасовано, завершено)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
