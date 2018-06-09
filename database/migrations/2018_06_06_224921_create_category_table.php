<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('category', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name', 50)->nullable()->default('')->comment('//分类名称');
			$table->string('title')->nullable()->default('')->comment('//分类说明');
			$table->string('keywords')->nullable()->default('')->comment('//关键词');
			$table->string('description')->nullable()->default('')->comment('//描述');
			$table->integer('view')->nullable()->default(0)->comment('//查看次数');
			$table->integer('order')->nullable()->default(0)->comment('//排序');
			$table->integer('pid')->nullable()->default(0)->comment('//父级id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('category');
	}

}
