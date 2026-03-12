<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->date('start_date')->nullable();
            $table->date('expected_date')->nullable();
            $table->date('finished_date')->nullable();
            $table->string('responsible')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['work_id', 'status']);
            $table->index(['work_id', 'expected_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_stages');
    }
};
