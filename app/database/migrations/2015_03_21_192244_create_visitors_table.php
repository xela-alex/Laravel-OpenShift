<?php

use Illuminate\Database\Migrations\Migration;

class CreateVisitorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('visitor', function($table)
		{
			$table->increments('id');
			$table->string('ipAddress');
			$table->integer('campaign_id')->unsigned()->index();
			$table->foreign('campaign_id')->references('id')->on('campaign')->onDelete('cascade');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('visitor');
	}

}
