<?php

class Add_Alt_Id_Formquestion {    

	public function up()
    {
		Schema::table('formquestion', function($table) {
			$table->integer('alt_id')->unsigned()->default(NULL);
		});
    }    

	public function down()
    {
		Schema::table('formquestion', function($table) {
			$table->drop_column('alt_id');
		});
    }
}





