<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // $table->string('mobile_no');
            // $table->string('address');
            // $table->string('city');
            // $table->string('state');
            // $table->string('zip');
            // $table->string('country');
            $table->integer('role');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {            
            // $table->dropColumn('mobile_no');
            // $table->dropColumn('address');
            // $table->dropColumn('city');
            // $table->dropColumn('state');
            // $table->dropColumn('zip');
            // $table->dropColumn('country');
            $table->dropColumn('role');
        });
    }
}
