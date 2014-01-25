<?php

use Illuminate\Database\Migrations\Migration;

class CreateFriendshipsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('friendships', function($table)
		{
			$table->increments('id');
			$table->integer('sender_id')->unsigned();
			$table->integer('receiver_id')->unsigned();
			$table->integer('status')->default(0);
			$table->integer('created');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('friendships');
	}

}
