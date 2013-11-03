<?php

class CreateDisabilityCategory {    

	public function up()
    {
		Schema::create('disabilitycategory', function($table) {
			$table->increments('id');
			$table->string('npa_disability_category');
			$table->string('ers_disability_category');
			$table->timestamps();
		});
    }    

	public function down()
    {
		Schema::drop('disabilitycategory');
    }
}