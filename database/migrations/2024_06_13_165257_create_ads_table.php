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
        // объявления
        Schema::create('ads', function (Blueprint $table) {
            $table->id()->comment('Уникальный идентификатор');
            $table->string('name', 200)->comment('Название');
            $table->string('slug', 221)->unique()->comment('URL');
            $table->string('description', 1000)->nullable()->comment('Описание объявления');
            $table->integer('price')->default(0)->comment('Цена');
            $table->timestamps();
        });

        // фотографии для объявления
        Schema::create('photos', function (Blueprint $table) {
            $table->id()->comment('Уникальный идентификатор');
            $table->foreignId('ads_id')->comment('Идентификатор объявления');
            $table->text('filename')->comment('Имя файла');

            // внешний ключ
            $table->foreign('ads_id')->references('id')->on('ads');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos');
        Schema::dropIfExists('ads');
    }
};
