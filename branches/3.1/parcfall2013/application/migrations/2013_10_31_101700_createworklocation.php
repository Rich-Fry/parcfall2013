<?php

class CreateWorkLocation {    

	public function up()
    {
		Schema::create('worklocation', function($table) {
			$table->increments('id');
			$table->integer('work_location_code')->unsigned();
			$table->string('primary_work_location_name');
			$table->string('primary_work_location_zip');
			$table->string('primary_work_location_type');
			$table->string('primary_industry');
			$table->timestamps();
		});
    }    

	public function down()
    {
		Schema::drop('worklocation');
    }
}