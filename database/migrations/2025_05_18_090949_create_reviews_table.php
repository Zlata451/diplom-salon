<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();

            // 🔄 Поліморфний зв'язок
            $table->unsignedBigInteger('reviewable_id');
            $table->string('reviewable_type');

            $table->timestamps();

            // 🔐 Зовнішній ключ тільки для user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
