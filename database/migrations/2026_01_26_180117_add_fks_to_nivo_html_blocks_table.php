<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('nivo_h_t_m_l_blocks', function (Blueprint $table) {
            $table->foreignId('nivo_id')
                  ->constrained('nivos')
                  ->cascadeOnDelete();

            $table->foreignId('html_block_id')
                  ->constrained('h_t_m_l_blocks')
                  ->cascadeOnDelete();
        });
    }


    public function down(): void
    {
        Schema::table('nivo_h_t_m_l_blocks', function (Blueprint $table) {
            $table->dropForeign(['nivo_id']);
            $table->dropForeign(['html_block_id']);
            $table->dropColumn(['nivo_id', 'html_block_id']);
        });
    }
};
