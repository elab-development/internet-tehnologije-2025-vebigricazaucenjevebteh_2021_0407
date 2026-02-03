<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('nivos', function (Blueprint $table) {
        $table->longText('level_config')->nullable(); // čuva faze, blokove, pravila
    });
    }


    public function down(): void
    {
        Schema::table('nivos', function (Blueprint $table) {
        $table->dropColumn('level_config');
    });
    }
};
