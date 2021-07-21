<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCredentiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credentias', function (Blueprint $table) {
            $table->string('domain');
            $table->string('lang');
            $table->string('app_sid');
            $table->string('auth_id');
            $table->string('auth_expire');
            $table->string('refresh_id');
            $table->string('member_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credentias');
    }
}
