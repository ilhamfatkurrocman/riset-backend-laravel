<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    // MENJALANKAN MIGRATION
    public function up()
    {
        // SCHEMA TABLE
        Schema::table('users', function (Blueprint $table) {
            //Field Table User
            $table->string('roles')->after('email')->default('USER');
            $table->string('phone')->after('email')->nullable();
            $table->string('username')->after('email')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    // SEPERTI ROLLBACK
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('roles');
            $table->dropColumn('phone');
            $table->dropColumn('username');

        });
    }
}
