<?php

class Create_PersonnelFormType {

	public function up()
    {
		Schema::create('PersonnelFormType', function($table) {
			
			$table->increments('id');
			$table->string('formTitle');
			$table->timestamps();
		});
	}

	public function down()
	{
		//
		Schema::drop('PersonnelFormType');
	}

}