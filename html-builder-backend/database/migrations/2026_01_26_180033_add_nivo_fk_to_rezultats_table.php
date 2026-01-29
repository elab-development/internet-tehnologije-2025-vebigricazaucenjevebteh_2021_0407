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
        Schema::table('rezultats', function (Blueprint $table) {
        $table->foreignId('nivo_id')
              ->after('korisnik_id')
              ->constrained('nivos')
              ->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('rezultats', function (Blueprint $table) {
        $table->dropForeign(['nivo_id']);
        $table->dropColumn('nivo_id');
    });
    }
};
