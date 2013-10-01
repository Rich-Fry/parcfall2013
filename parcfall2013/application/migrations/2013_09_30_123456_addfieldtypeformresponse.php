<?php

class Addfieldtypeformresponse {    

	public function up()
    {
		Schema::table('FormQuestion', function($table) {
			$table->integer('fieldType')->unsigned()->default(1);
		});
    }    

	public function down()
    {
		Schema::table('FormQuestion', function($table) {
			$table->drop_column('fieldType');
		});
    }
}