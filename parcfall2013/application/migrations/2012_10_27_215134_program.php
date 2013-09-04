<?php

class Program {    

	public function up()
    {
		Schema::create('Program', function($table) {
			$table->increments('id');
			$table->string('programName');
			$table->string('programDescription');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('Program');

    }

}