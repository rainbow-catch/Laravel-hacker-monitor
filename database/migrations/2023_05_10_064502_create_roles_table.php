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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->boolean('see_home');
            $table->boolean('see_screenshots');
            $table->boolean('see_hack_logs');
            $table->boolean('see_connect_logs');
            $table->boolean('see_tools_download');
            $table->boolean('see_guides');
            $table->boolean('ban_hardware');
            $table->unsignedBigInteger('guest_id');

            $table->foreign('guest_id')
                ->on('users')
                ->references('id')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
