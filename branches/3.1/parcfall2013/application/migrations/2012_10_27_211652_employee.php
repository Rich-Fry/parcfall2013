<?php

class Employee {    

	public function up()
    {
		Schema::create('Employee', function($table) {
			$table->increments('id');
			$table->string('firstName');
			$table->string('lastName');
			$table->boolean('client')->default(0);
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('Employee');

    }

}