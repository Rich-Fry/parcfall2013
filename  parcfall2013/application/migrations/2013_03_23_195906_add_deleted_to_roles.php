<?php

class Add_Deleted_To_Roles {    

	public function up()
    {
		Schema::table('roles', function($table)
		{
			$table->boolean('deleted')->default(0);
		});
	}

	public function down()
    {
		Schema::table('roles', function($table)
		{
			$table->drop_column('deleted');
		});
    }

}