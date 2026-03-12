<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('developments', function (Blueprint $table) {
            if (! Schema::hasColumn('developments', 'location')) {
                $table->string('location')->nullable()->after('description');
            }

            if (! Schema::hasColumn('developments', 'launch_date')) {
                $table->date('launch_date')->nullable()->after('status');
            }

            if (! Schema::hasColumn('developments', 'expected_delivery')) {
                $table->date('expected_delivery')->nullable()->after('launch_date');
            }

            if (! Schema::hasColumn('developments', 'notes')) {
                $table->text('notes')->nullable()->after('expected_delivery');
            }

            $table->string('status')->default('planejamento')->change();
        });

        $statusMap = [
            'planning' => 'planejamento',
            'in_progress' => 'em_obras',
            'paused' => 'lancamento',
            'completed' => 'finalizado',
            'canceled' => 'cancelado',
        ];

        $rows = DB::table('developments')->select([
            'id',
            'status',
            'address',
            'city',
            'state',
            'start_date',
            'expected_delivery_date',
            'location',
            'launch_date',
            'expected_delivery',
        ])->get();

        foreach ($rows as $row) {
            $updates = [];
            $locationParts = array_filter([
                $row->address,
                trim(collect([$row->city, $row->state])->filter()->implode('/')),
            ]);
            $resolvedLocation = trim(implode(' - ', $locationParts));

            if (empty($row->location) && $resolvedLocation !== '') {
                $updates['location'] = $resolvedLocation;
            }

            if (empty($row->launch_date) && $row->start_date) {
                $updates['launch_date'] = $row->start_date;
            }

            if (empty($row->expected_delivery) && $row->expected_delivery_date) {
                $updates['expected_delivery'] = $row->expected_delivery_date;
            }

            if (isset($statusMap[$row->status])) {
                $updates['status'] = $statusMap[$row->status];
            }

            if ($updates !== []) {
                DB::table('developments')->where('id', $row->id)->update($updates);
            }
        }
    }

    public function down(): void
    {
        Schema::table('developments', function (Blueprint $table) {
            if (Schema::hasColumn('developments', 'notes')) {
                $table->dropColumn('notes');
            }

            if (Schema::hasColumn('developments', 'expected_delivery')) {
                $table->dropColumn('expected_delivery');
            }

            if (Schema::hasColumn('developments', 'launch_date')) {
                $table->dropColumn('launch_date');
            }

            if (Schema::hasColumn('developments', 'location')) {
                $table->dropColumn('location');
            }

            $table->string('status')->default('planning')->change();
        });
    }
};
