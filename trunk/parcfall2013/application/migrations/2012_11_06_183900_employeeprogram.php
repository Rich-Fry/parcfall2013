<?php

class EmployeeProgram {    

	public function up()
    {
		Schema::create('EmployeeProgram', function($table) {
			$table->increments('id');
			$table->integer('employee_id')->unsigned();
			$table->integer('program_id')->unsigned();
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('EmployeeProgram');

    }

}