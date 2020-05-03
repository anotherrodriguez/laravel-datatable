<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsFromTimEmail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sites', function (Blueprint $table) {
            //
            $table->string('name')->change();
            $table->text('address');
            $table->text('city');
            $table->text('state');
            $table->text('zip_code');
        });

        Schema::table('departments', function (Blueprint $table) {
            //
            $table->string('name')->change();
        });

        Schema::table('statuses', function (Blueprint $table) {
            //
            $table->string('name')->change();
        });

        Schema::table('patients', function (Blueprint $table) {
            //
            $table->string('email_1')->nullable();
            $table->string('email_2')->nullable();
            $table->string('email_3')->nullable();
            $table->string('phone_number_1')->nullable();
            $table->string('phone_number_2')->nullable();
            $table->string('phone_number_3')->nullable();
            $table->date('date_of_service')->nullable();
            $table->dropColumn('email');
            $table->dropColumn('phone_number');
        });

        Schema::table('statuses', function (Blueprint $table) {
            //
            $table->integer('list_order');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sites', function (Blueprint $table) {
            //
            $table->text('name')->change();
            $table->dropColumn('address');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('zip_code');
        });

        Schema::table('departments', function (Blueprint $table) {
            //
            $table->text('name')->change();
        });

        Schema::table('statuses', function (Blueprint $table) {
            //
            $table->text('name')->change();
        });

        Schema::table('patients', function (Blueprint $table) {
            //
            $table->dropColumn('email_1');
            $table->dropColumn('email_2');
            $table->dropColumn('email_3');
            $table->dropColumn('phone_number_1');
            $table->dropColumn('phone_number_2');
            $table->dropColumn('phone_number_3');
            $table->dropColumn('date_of_service');
            $table->string('email');
            $table->string('phone_number', 15);
        });

        Schema::table('statuses', function (Blueprint $table) {
            //
            $table->dropColumn('list_order');
        });

    }
}
