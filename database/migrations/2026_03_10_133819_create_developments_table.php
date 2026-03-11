<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('developments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('builder_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->enum('type', ['houses', 'apartments']);
            $table->string('city');
            $table->string('state', 2);
            $table->string('address')->nullable();
            $table->date('start_date')->nullable();
            $table->date('expected_delivery_date')->nullable();
            $table->enum('status', [
                'planning',
                'in_progress',
                'paused',
                'completed',
                'canceled',
            ])->default('planning');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('developments');
    }
};
