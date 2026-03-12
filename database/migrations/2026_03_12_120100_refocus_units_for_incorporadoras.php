<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('units', function (Blueprint $table) {
            if (! Schema::hasColumn('units', 'block_or_tower')) {
                $table->string('block_or_tower')->nullable()->after('block');
            }

            if (! Schema::hasColumn('units', 'unit_number')) {
                $table->string('unit_number')->nullable()->after('identifier');
            }

            if (! Schema::hasColumn('units', 'area')) {
                $table->decimal('area', 10, 2)->nullable()->after('total_area');
            }

            if (! Schema::hasColumn('units', 'bedrooms')) {
                $table->unsignedInteger('bedrooms')->nullable()->after('area');
            }

            if (! Schema::hasColumn('units', 'parking_spaces')) {
                $table->unsignedInteger('parking_spaces')->nullable()->after('bedrooms');
            }

            $table->string('status')->default('disponivel')->change();
        });

        $statusMap = [
            'available' => 'disponivel',
            'reserved' => 'reservada',
            'sold' => 'vendida',
            'blocked' => 'bloqueada',
        ];

        $rows = DB::table('units')->select([
            'id',
            'identifier',
            'block',
            'private_area',
            'total_area',
            'status',
            'block_or_tower',
            'unit_number',
            'area',
        ])->get();

        foreach ($rows as $row) {
            $updates = [];

            if (empty($row->unit_number) && ! empty($row->identifier)) {
                $updates['unit_number'] = $row->identifier;
            }

            if (empty($row->block_or_tower) && ! empty($row->block)) {
                $updates['block_or_tower'] = $row->block;
            }

            if (empty($row->area) && ($row->private_area || $row->total_area)) {
                $updates['area'] = $row->private_area ?: $row->total_area;
            }

            if (isset($statusMap[$row->status])) {
                $updates['status'] = $statusMap[$row->status];
            }

            if ($updates !== []) {
                DB::table('units')->where('id', $row->id)->update($updates);
            }
        }
    }

    public function down(): void
    {
        Schema::table('units', function (Blueprint $table) {
            if (Schema::hasColumn('units', 'parking_spaces')) {
                $table->dropColumn('parking_spaces');
            }

            if (Schema::hasColumn('units', 'bedrooms')) {
                $table->dropColumn('bedrooms');
            }

            if (Schema::hasColumn('units', 'area')) {
                $table->dropColumn('area');
            }

            if (Schema::hasColumn('units', 'unit_number')) {
                $table->dropColumn('unit_number');
            }

            if (Schema::hasColumn('units', 'block_or_tower')) {
                $table->dropColumn('block_or_tower');
            }

            $table->string('status')->default('available')->change();
        });
    }
};
