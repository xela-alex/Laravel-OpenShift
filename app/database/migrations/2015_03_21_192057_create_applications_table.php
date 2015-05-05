<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('application', function($table)
		{
			$table->increments('id');
			$table->date('moment');
			$table->Text('comments')->nullable();
			$table->integer('result');


			$table->integer('volunteer_id')->unsigned()->index();
			$table->foreign('volunteer_id')->references('id')->on('volunteer');


			$table->integer('project_id')->unsigned()->index();
			$table->foreign('project_id')->references('id')->on('project');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('application');
	}

}
