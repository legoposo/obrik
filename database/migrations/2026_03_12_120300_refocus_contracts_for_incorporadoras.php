<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            if (! Schema::hasColumn('contracts', 'value')) {
                $table->decimal('value', 12, 2)->nullable()->after('contract_date');
            }

            $table->string('status')->default('reserva')->change();
        });

        $statusMap = [
            'ativo' => 'reserva',
            'assinado' => 'contrato_assinado',
            'cancelado' => 'cancelado',
            'concluido' => 'concluido',
        ];

        $rows = DB::table('contracts')->select(['id', 'status', 'negotiated_value', 'unit_price', 'value'])->get();

        foreach ($rows as $row) {
            $updates = [];

            if (empty($row->value) && ($row->negotiated_value || $row->unit_price)) {
                $updates['value'] = $row->negotiated_value ?: $row->unit_price;
            }

            if (isset($statusMap[$row->status])) {
                $updates['status'] = $statusMap[$row->status];
            }

            if ($updates !== []) {
                DB::table('contracts')->where('id', $row->id)->update($updates);
            }
        }
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            if (Schema::hasColumn('contracts', 'value')) {
                $table->dropColumn('value');
            }

            $table->string('status')->default('ativo')->change();
        });
    }
};
