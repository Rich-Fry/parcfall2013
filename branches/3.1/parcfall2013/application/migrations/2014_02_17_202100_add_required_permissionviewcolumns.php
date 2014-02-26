<?php

class add_required_permissionviewcolumns {    

	public function up()
    {
		Schema::table('Program', function($table) {
			$table->integer('viewobjectid')->unsigned()->default(NULL);
		});
		Schema::table('users', function($table) {
			$table->integer('viewobjectid')->unsigned()->default(NULL);
		});
    }    

	public function down()
    {
    	Schema::table('Program', function($table) {
			$table->drop_column('viewobjectid');
		});
    	Schema::table('users', function($table) {
			$table->drop_column('viewobjectid');
		});
    }

}