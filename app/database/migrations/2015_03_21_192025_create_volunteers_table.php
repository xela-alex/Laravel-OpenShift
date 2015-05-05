<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVolunteersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
			Schema::create('volunteer', function($table)
			{
				//Actor Abstract
			$table->increments('id');
			$table->string('name');
			$table->boolean('banned')->default(false);


			//location datatype
			$table->string('address')->nullable();
			$table->string('city');
			$table->string('zipCode');
			$table->string('country');


			$table->string('surname');
			$table->String('biography')->nullable();


			$table->integer('user_id')->unsigned()->index();
			$table->foreign('user_id')->references('id')->on('users');



		});

		Schema::create('project_volunteer', function($table)
		{
			$table->increments('id');
			$table->integer('project_id')->unsigned()->index();
			$table->integer('volunteer_id')->unsigned()->index();
			$table->foreign('project_id')->references('id')->on('project')->onDelete('cascade');
			$table->foreign('volunteer_id')->references('id')->on('volunteer')->onDelete('cascade');

		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('project_volunteer');
		Schema::drop('volunteer');


	}

}
