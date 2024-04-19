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
        Schema::create('matches_config', function (Blueprint $table) {
            $table->id();
            $table->integer('goal_keeper_fix')->default(1);
            $table->integer('prioritize_payers')->default(1);
            $table->integer('max_playes_line');
            $table->integer('distinct_team')->default(0);
            $table->integer('type_sortition')->default(0);
            $table->bigInteger('match_id')->unsigned()->index();
            $table->foreign('match_id')->references('id')->on('matches_soccer')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches_config');
    }
};
