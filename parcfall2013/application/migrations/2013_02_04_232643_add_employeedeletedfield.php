<?php

class Add_Employeedeletedfield {

	/**
	* Make changes to the database.
	*
	* @return void
	*/
	public function up()
	{
		Schema::table('Employee', function($table)
		{
			$table->boolean('deleted')->default(0);
		});
	}

	public function down()
	{
		Schema::table('Employee', function($table)
		{
			$table->drop_column('deleted');
		});

	}



}