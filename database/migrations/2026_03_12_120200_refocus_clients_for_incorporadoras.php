<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            if (! Schema::hasColumn('clients', 'document')) {
                $table->string('document')->nullable()->after('phone');
            }

            if (! Schema::hasColumn('clients', 'notes')) {
                $table->text('notes')->nullable()->after('address');
            }

            if (! Schema::hasColumn('clients', 'status')) {
                $table->string('status')->default('lead')->after('notes');
            }
        });

        $rows = DB::table('clients')->select(['id', 'cpf', 'rg', 'document'])->get();

        foreach ($rows as $row) {
            $document = $row->document ?: ($row->cpf ?: $row->rg);

            if ($document) {
                DB::table('clients')->where('id', $row->id)->update([
                    'document' => $document,
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            if (Schema::hasColumn('clients', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('clients', 'notes')) {
                $table->dropColumn('notes');
            }

            if (Schema::hasColumn('clients', 'document')) {
                $table->dropColumn('document');
            }
        });
    }
};
