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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('placement_id')->unsigned()->unique(); // one evaluation per placement
            $table->integer('technical_skills');
            $table->integer('teamwork');
            $table->integer('communication');
            $table->integer('punctuality');
            $table->integer('initiative');
            $table->integer('total');           // out of 25
            $table->text('comments')->nullable();
            $table->string('status')->default('draft'); // draft, submitted
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
