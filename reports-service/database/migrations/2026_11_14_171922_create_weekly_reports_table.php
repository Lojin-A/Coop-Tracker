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
        Schema::create('weekly_reports', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('placement_id')->unsigned()->index();
            $table->integer('week_no');
            $table->text('content')->nullable();
            $table->string('file_path')->nullable();
            $table->string('status')->default('draft'); // draft, submitted, reviewed, changes_requested
            $table->text('feedback')->nullable();
            $table->timestamps();
            $table->unique(['placement_id', 'week_no']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_reports');
    }
};
