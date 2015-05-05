<?php

use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->text('description');
			$table->string('image')->nullable();
			$table->string('address');
			$table->string('city');
			$table->string('zipCode');
			$table->string('country');
			$table->integer('maxVolunteers');
			$table->date('startDate');
			$table->date('finishDate');
			$table->timestamps();
			$table->integer('ngo_id')->unsigned()->index()->nullable();
			$table->integer('company_id')->unsigned()->index()->nullable();
			$table->foreign('ngo_id')->references('id')->on('ngo')->onDelete('cascade');
			$table->foreign('company_id')->references('id')->on('company')->onDelete('cascade');

		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('project');
	}

}
