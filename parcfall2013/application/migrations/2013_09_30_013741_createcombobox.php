<?php

class CreatecomboBox {    

	public function up()
    {
		Schema::create('comboboxfields', function($table) {
			$table->increments('id')->primary();
			
			$table->integer('formQuestion_id')->unsigned();
			$table->integer('roles_id')->unsigned();
			$table->string('comboValue');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('comboboxfields');

    }

}