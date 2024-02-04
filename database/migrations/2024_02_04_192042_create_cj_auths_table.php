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
        Schema::create('cj_auths', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->text('key')->nullable();
            $table->text('access_token')->nullable();
            $table->dateTime('access_token_expiry_date')->nullable();
            $table->dateTime('refresh_token_expiry_date')->nullable();
            $table->text('refresh_token')->nullable();
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
        Schema::dropIfExists('cj_auths');
    }
};
