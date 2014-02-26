<?php

class TrackedItem {    

	public function up()
    {
		Schema::create('TrackedItem', function($table) {
			$table->increments('id');
			$table->string('itemUrl')->nullable();
			$table->string('itemName');
			$table->string('itemDescription')->nullable();
			$table->integer('employee_id')->unsigned();
			$table->integer('trackedcategory_id')->unsigned();
			$table->date('itemExpiration')->nullable();
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('TrackedItem');

    }

}