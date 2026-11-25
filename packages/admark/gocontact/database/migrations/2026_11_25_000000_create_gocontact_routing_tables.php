<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gocontact_routing_counters', function (Blueprint $table) {
            $table->string('id', 32)->primary();
            $table->string('policy_key', 64)->nullable();
            $table->unsignedSmallInteger('remainder')->default(0);
            $table->timestamp('updated_at')->nullable();
        });

        DB::table('gocontact_routing_counters')->insert(['id' => 'default', 'remainder' => 0]);

        Schema::create('gocontact_routing_assignments', function (Blueprint $table) {
            $table->unsignedInteger('form_id')->primary();
            $table->foreign('form_id')->references('id')->on('forms')->cascadeOnDelete();
            $table->string('database_id', 191)->index();
            $table->unsignedSmallInteger('alternate_percentage');
            $table->timestamp('created_at');
        });

        Schema::table('gocontact_submissions', function (Blueprint $table) {
            $table->string('database_id', 191)->nullable()->index();
        });
    }

    public function down(): void
    {
        Schema::table('gocontact_submissions', function (Blueprint $table) {
            $table->dropIndex(['database_id']);
            $table->dropColumn('database_id');
        });
        Schema::dropIfExists('gocontact_routing_assignments');
        Schema::dropIfExists('gocontact_routing_counters');
    }
};
