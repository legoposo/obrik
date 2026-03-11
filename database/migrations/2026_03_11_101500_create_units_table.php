<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('development_id')->constrained()->cascadeOnDelete();
            $table->string('identifier');
            $table->string('type');
            $table->string('block')->nullable();
            $table->string('floor')->nullable();
            $table->decimal('private_area', 10, 2)->nullable();
            $table->decimal('total_area', 10, 2)->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->enum('status', ['available', 'reserved', 'sold', 'blocked'])->default('available');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['development_id', 'identifier']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
