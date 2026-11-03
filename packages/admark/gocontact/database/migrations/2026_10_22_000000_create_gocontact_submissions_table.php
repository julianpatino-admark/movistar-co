<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gocontact_submissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('form_id')->nullable();
            $table->foreign('form_id')->references('id')->on('forms')->nullOnDelete();
            $table->string('gocontact_id', 191)->nullable()->index();
            $table->boolean('successful')->index();
            $table->string('stage', 64);
            $table->unsignedSmallInteger('http_status')->nullable();
            $table->text('error')->nullable();
            $table->json('diagnostics')->nullable();
            $table->unsignedInteger('duration_ms')->default(0);
            $table->timestamps();

            $table->index(['successful', 'created_at']);
            $table->index(['form_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gocontact_submissions');
    }
};
