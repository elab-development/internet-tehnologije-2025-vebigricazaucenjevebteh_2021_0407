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
        Schema::create('h_t_m_l_blocks', function (Blueprint $table) {
        $table->id();
        $table->foreignId('nivo_id')->constrained('nivos')->onDelete('cascade');
        $table->foreignId('html_block_id')->constrained('h_t_m_l_blocks')->onDelete('cascade');
        $table->boolean('obaveznost');
        $table->integer('redosled');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('h_t_m_l_blocks');
    }
};
