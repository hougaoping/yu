<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Config;

class CreateArticleCategoriesTable extends Migration
{
	
    public function up()
    {
	
		Schema::create('article_categories', function (Blueprint $table) {
			$table->increments('id');
            $table->string('name');
			$table->nestedSet();
			$table->timestamps();
        });
    }

    public function down()
    {
		Schema::dropIfExists('article_categories');
    }
}
