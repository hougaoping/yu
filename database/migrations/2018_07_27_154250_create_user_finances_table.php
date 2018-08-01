<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFinancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_finances', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger('user_id')->index();
			$table->string('description')->nullable();
			$table->string('enum')->index(); 
			$table->decimal('change',12, 2);
			$table->decimal('amount',12, 2);
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
        Schema::dropIfExists('user_finances');
    }
}
