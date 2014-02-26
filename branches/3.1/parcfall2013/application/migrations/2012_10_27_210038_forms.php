<?php

class Forms {    

	public function up()
    {
		Schema::create('Form', function($table) {
			$table->increments('id');
			$table->string('formName');
			$table->string('formDescription');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('Form');
    }

}