<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('masters', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ім’я майстра
            $table->string('specialty'); // Спеціалізація (напр. перукар, косметолог)
            $table->string('phone')->nullable(); // Телефон
            $table->string('email')->nullable(); // Електронна пошта
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('masters');
    }
};
