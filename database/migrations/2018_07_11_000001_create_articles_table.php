<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Config;

class CreateArticlesTable extends Migration
{
	
    public function up()
    {
	
		Schema::create('articles', function (Blueprint $table) {
			$table->increments('id');
            $table->string('title');
			$table->unsignedInteger('article_category_id')->index()->default(0);
			$table->longText('content');
			$table->boolean('status')->default(true);
			$table->timestamps();
        });
    }

    public function down()
    {
		Schema::dropIfExists('articles');
    }
}
