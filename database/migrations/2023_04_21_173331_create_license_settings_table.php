<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('license_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean("name");
            $table->boolean("memory");
            $table->boolean("launcher");
            $table->boolean("crc32");
            $table->boolean("system");
            $table->boolean("instance");
        });
        \App\Models\LicenseSetting::factory()->create([
            'name' => true,
            'memory' => true,
            'launcher' => true,
            'crc32' => true,
            'system' => true,
            'instance' => true,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('license_settings');
    }
};
