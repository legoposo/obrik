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
        Schema::create('financial_entries', function (Blueprint $table) {
            $table->id();

            // Relação com obra
            $table->foreignId('work_id')
                ->constrained()
                ->cascadeOnDelete();

            // Relação com cliente (opcional)
            $table->foreignId('client_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Tipo do lançamento
            $table->enum('type', ['income', 'expense']);

            // Descrição
            $table->string('description');

            // Valor
            $table->decimal('amount', 12, 2);

            // Datas
            $table->date('due_date')->nullable();
            $table->date('paid_at')->nullable();

            // Status
            $table->enum('status', ['pending', 'paid', 'overdue'])
                ->default('pending');

            // Observações
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_entries');
    }
};
