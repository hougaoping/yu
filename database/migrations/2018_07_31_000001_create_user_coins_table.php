<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_coins', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger('user_id')->index();
			$table->string('causer_type');
			$table->unsignedInteger('causer_id')->index();
			$table->string('description')->nullable();
			$table->string('enum')->index(); 
			$table->unsignedInteger('change');
			$table->unsignedInteger('coin');
            $table->timestamps();
			$table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_coins');
    }
}
