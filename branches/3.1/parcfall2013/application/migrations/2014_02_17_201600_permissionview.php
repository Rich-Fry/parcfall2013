<?php

class permissionview {    

	public function up()
    {
		Schema::create('permissionview', function($table) {
			$table->increments('id');
            $table->integer('objectid')->unsigned();
			$table->integer('permission_id')->unsigned();
	});

    }    

	public function down()
    {
		Schema::drop('permissionview');
    }

}