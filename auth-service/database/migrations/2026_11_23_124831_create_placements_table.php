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
        Schema::create('placements', function (Blueprint $table) {
            $table->id();
            // One placement per student: the database enforces it, not only the validation
            $table->foreignId('student_id')->unique()->constrained('users');
            $table->foreignId('supervisor_id')->constrained('users');
            $table->foreignId('company_id')->constrained();
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedInteger('required_weeks');
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('placements');
    }
};
