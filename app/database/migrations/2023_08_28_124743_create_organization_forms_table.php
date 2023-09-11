<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('organization_forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });

        DB::table('organization_forms')->insert([
            [
                'name' => 'ИП',
                'slug' => 'ip',
            ],
            [
                'name' => 'OOO',
                'slug' => 'ltd',
            ],
            [
                'name' => 'Самозанятый',
                'slug' => 'sz',
            ],
            [
                'name' => 'Физ. лицо',
                'slug' => 'fiz',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_forms');
    }
};
