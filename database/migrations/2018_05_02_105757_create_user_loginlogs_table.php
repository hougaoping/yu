<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLoginlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_loginlogs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
			$table->string('username', 100)->index();
			$table->boolean('result')->default(true);
            $table->boolean('is_admin')->default(false);
            $table->string('url')->default('');
			$table->unsignedInteger('login_time')->index();
			$table->string('ip', 50)->default('');
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
        Schema::dropIfExists('user_loginlogs');
    }
}
