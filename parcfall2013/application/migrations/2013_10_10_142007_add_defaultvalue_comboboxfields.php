<?php

class Add_DefaultValue_Comboboxfields {    

	public function up()
    {
		Schema::table('comboboxfields', function($table) {
			$table->integer('defaultValue')->unsigned()->default(NULL);
		});
    }    

	public function down()
    {
		Schema::table('comboboxfields', function($table) {
			$table->drop_column('defaultValue');
		});
    }
}
    
    