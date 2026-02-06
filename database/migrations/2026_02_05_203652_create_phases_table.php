<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

   public function up(): void
{
    Schema::create('phases', function (Blueprint $table) {
        $table->id();

        $table->foreignId('nivo_id')
              ->constrained('nivos')
              ->onDelete('cascade');

        $table->string('naziv');
        $table->text('opis');
        $table->json('blocks');
        $table->json('solution');
        $table->json('rules')->nullable();
        $table->text('hint')->nullable();
        $table->integer('order');

        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('phases');
    }
};
