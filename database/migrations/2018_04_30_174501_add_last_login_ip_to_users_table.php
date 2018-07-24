<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLastLoginIpToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('last_login_time')->default(0);
            $table->unsignedInteger('register_time')->default(0);
            $table->string('last_login_ip')->default('');
            $table->string('register_ip')->default('');
            
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
            $table->dropColumn(['last_login_time', 'register_time', 'last_login_ip', 'register_ip']);
        });
    }
}
