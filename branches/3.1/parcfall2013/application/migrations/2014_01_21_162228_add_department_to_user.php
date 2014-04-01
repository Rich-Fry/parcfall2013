<?php

class Add_Department_To_User {    

	public function up()
    {
		Schema::table('users', function($table)
		{
			$table->String('department')->default(NULL);
		});
	}

	public function down()
    {
		Schema::table('users', function($table)
		{
			$table->drop_column('department');
		});
    }

}