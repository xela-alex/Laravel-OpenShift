<?php

use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('message', function($table)
		{
			$table->increments('id');
			$table->string('subject');
			$table->text('textBox');
			$table->date('date');
			$table->String('from');
			$table->String('to');
			$table->integer('administrator_id')->unsigned()->index()->nullable();
			$table->foreign('administrator_id')->references('id')->on('administrator')->onDelete('cascade');
			$table->integer('ngo_id')->unsigned()->index()->nullable();
			$table->foreign('ngo_id')->references('id')->on('ngo')->onDelete('cascade');
			$table->integer('volunteer_id')->unsigned()->index()->nullable();
			$table->foreign('volunteer_id')->references('id')->on('volunteer')->onDelete('cascade');
			$table->integer('company_id')->unsigned()->index()->nullable();
			$table->foreign('company_id')->references('id')->on('company')->onDelete('cascade');
		});

		Schema::create('message_recipient', function($table)
		{
			$table->increments('id');
			$table->boolean('read')->default(false);
			$table->integer('message_id')->unsigned()->index();
			$table->foreign('message_id')->references('id')->on('message')->onDelete('cascade');
			$table->integer('recipient_administrator_id')->unsigned()->index()->nullable();
			$table->foreign('recipient_administrator_id')->references('id')->on('administrator')->onDelete('cascade');
			$table->integer('recipient_company_id')->unsigned()->index()->nullable();
			$table->foreign('recipient_company_id')->references('id')->on('company')->onDelete('cascade');
			$table->integer('recipient_ngo_id')->unsigned()->index()->nullable();
			$table->foreign('recipient_ngo_id')->references('id')->on('ngo')->onDelete('cascade');
			$table->integer('recipient_volunteer_id')->unsigned()->index()->nullable();
			$table->foreign('recipient_volunteer_id')->references('id')->on('volunteer')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('message');
		Schema::drop('message_recipient');
	}

}
