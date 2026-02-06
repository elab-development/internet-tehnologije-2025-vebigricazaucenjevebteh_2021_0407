<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('korisniks', function (Blueprint $table) {
    $table->id();
    $table->string('ime');
    $table->string('email')->unique();
    $table->string('password');
    $table->string('tip_korisnika')->default('registrovani');
    $table->timestamps();
});
    }


    public function down(): void
    {
        Schema::dropIfExists('korisniks');
    }
};
