<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('development_stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('development_id')->constrained()->cascadeOnDelete();
            $table->string('stage_name');
            $table->string('status')->default('pendente');
            $table->date('start_date')->nullable();
            $table->date('expected_date')->nullable();
            $table->date('finished_date')->nullable();
            $table->string('responsible')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['development_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('development_stages');
    }
};
