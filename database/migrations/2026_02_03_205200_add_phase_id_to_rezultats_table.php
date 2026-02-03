<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('rezultats', function (Blueprint $table) {
            $table->string('phase_id')->nullable()->after('nivo_id');


            $table->unique(['korisnik_id', 'nivo_id', 'phase_id'], 'uniq_korisnik_nivo_phase');
        });
    }

    public function down(): void
    {
        Schema::table('rezultats', function (Blueprint $table) {
            $table->dropUnique('uniq_korisnik_nivo_phase');
            $table->dropColumn('phase_id');
        });
    }
};

