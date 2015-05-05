<?php


use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('category', function($table)
		{
			$table->increments('id');
			$table->string('name')->unique();

		});

		Schema::create('project_category', function($table)
		{
			$table->increments('id');
			$table->integer('project_id')->unsigned()->index();
			$table->integer('category_id')->unsigned()->index();
			$table->foreign('project_id')->references('id')->on('project')->onDelete('cascade');
			$table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');

		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('project_category');
		Schema::drop('category');

	}

}
