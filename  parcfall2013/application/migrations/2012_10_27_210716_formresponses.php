<?php

class Formresponses {    

	public function up()
    {
		Schema::create('QuestionResponse', function($table) {
			$table->increments('id');
			$table->integer('formquestion_id')->unsigned();
			$table->string('response');
			$table->integer('dataform_id');
			$table->integer('employee_id')->unsigned();
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('QuestionResponse');

    }

}