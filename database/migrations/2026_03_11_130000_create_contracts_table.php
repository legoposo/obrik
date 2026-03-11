<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('development_id')->constrained()->cascadeOnDelete();
            $table->foreignId('unit_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->string('contract_number')->unique();
            $table->date('sale_date');
            $table->date('contract_date');
            $table->decimal('unit_price', 12, 2);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('negotiated_value', 12, 2);
            $table->decimal('down_payment', 12, 2)->default(0);
            $table->decimal('financed_amount', 12, 2)->default(0);
            $table->unsignedInteger('installments_count')->default(0);
            $table->enum('status', ['ativo', 'assinado', 'cancelado', 'concluido'])->default('ativo');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['development_id', 'unit_id']);
            $table->index(['client_id', 'status']);
            $table->index(['status', 'contract_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
