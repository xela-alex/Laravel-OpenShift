<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('company', function($table)
		{
			//Actor Abstract
			$table->increments('id');
			$table->string('name');
			$table->boolean('banned')->default(false);



			$table->string('sector');
			$table->text('description');
			$table->string('phone');
			$table->String('logo')->nullable();
			$table->boolean('active')->default(false);



			$table->integer('user_id')->unsigned()->index();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');



		});


	}



	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('company');
	}

}
