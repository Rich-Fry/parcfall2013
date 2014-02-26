<?php

class AddDeletedToProgram {    

	public function up()
    {
		Schema::table('Program', function($table)
		{
			$table->boolean('deleted')->default(0);
		});
	}

	public function down()
    {
		Schema::table('Program', function($table)
		{
			$table->drop_column('deleted');
		});
    }

}