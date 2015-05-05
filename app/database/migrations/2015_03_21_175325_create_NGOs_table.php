<?php

use Illuminate\Database\Migrations\Migration;

class CreateNGOsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ngo', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('banned')->default(false);
            $table->string('holderName');
            $table->string('brandName');
            $table->string('number');
            $table->integer('expirationMonth')->unsigned();
            $table->integer('expirationYear')->unsigned();
            $table->integer('cvv')->unsigned();
            $table->text('description');
            $table->string('phone');
            $table->string('logo')->nullable();
            $table->boolean('active')->default(false);
            $table->integer('credits')->unsigned()->default(0);
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
        Schema::drop('ngo');
    }

}
