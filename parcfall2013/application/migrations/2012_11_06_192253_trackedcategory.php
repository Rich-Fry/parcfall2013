<?php

class TrackedCategory {    

	public function up()
    {
		Schema::create('TrackedCategory', function($table) {
			$table->increments('id');
			$table->string('categoryName');
			$table->string('categoryDescription')->nullable();
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('TrackedCategory');
    }

}