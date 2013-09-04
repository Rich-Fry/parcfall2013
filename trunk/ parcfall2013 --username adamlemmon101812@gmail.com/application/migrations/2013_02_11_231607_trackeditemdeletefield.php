<?php

class TrackedItemDeleteField {    

	public function up()
	{
		Schema::table('TrackedItem', function($table)
		{
			$table->boolean('deleted')->default(0);
		});
	}

	public function down()
	{
		Schema::table('TrackedItem', function($table)
		{
			$table->drop_column('deleted');
		});

	}

}