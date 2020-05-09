<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropEmailCol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn(['email_1']);
            $table->dropColumn(['email_2']);
            $table->dropColumn(['email_3']);
            $table->dropColumn(['phone_number_1']);
            $table->dropColumn(['phone_number_2']);
            $table->dropColumn(['phone_number_3']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('patients', function (Blueprint $table) {
            $table->string('email_1')->nullable();
            $table->string('email_2')->nullable();
            $table->string('email_3')->nullable();
            $table->string('phone_number_1')->nullable();
            $table->string('phone_number_2')->nullable();
            $table->string('phone_number_3')->nullable();
        });
    }
}
