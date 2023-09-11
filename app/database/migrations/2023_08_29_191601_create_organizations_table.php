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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->unsignedInteger("form")->nullable(false);
            $table->string("director");
            $table->string("logo");
            $table->time("start_at");
            $table->time("end_at");
            $table->jsonb("days");
            $table->foreign('form')->references('id')->on('organization_forms');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
