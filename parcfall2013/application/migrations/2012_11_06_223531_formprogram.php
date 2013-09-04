<?php

class FormProgram {    

	public function up()
    {
		Schema::create('FormProgram', function($table) {
			$table->increments('id');
			$table->integer('program_id')->unsigned();
			$table->integer('dataform_id')->unsigned();
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('FormProgram');

    }

}