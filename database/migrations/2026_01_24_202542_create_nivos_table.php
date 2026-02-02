<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

      public function up(): void
{
    Schema::create('nivos', function (Blueprint $table) {
        $table->id();
        $table->string('naziv');
        $table->text('opis')->nullable();
        $table->unsignedTinyInteger('tezina')->default(1);
        $table->json('expected')->nullable();
        $table->text('hint')->nullable();
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('nivos');
    }
};
