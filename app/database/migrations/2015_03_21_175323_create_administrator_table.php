<?php


use Illuminate\Database\Migrations\Migration;

class CreateAdministratorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('administrator', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->boolean('banned')->default(false);
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
		Schema::drop('administrator');
	}

}
