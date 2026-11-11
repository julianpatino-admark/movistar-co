<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('forms', 'queued_time')) {
            Schema::table('forms', function (Blueprint $table) {
                $table->integer('queued_time')->default(0);
            });
        }
    }

    public function down(): void
    {
        // Preserve queued lead delays, as in the original Tracking migration.
    }
};
