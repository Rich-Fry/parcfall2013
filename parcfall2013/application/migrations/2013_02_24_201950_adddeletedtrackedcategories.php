<?php

class AddDeletedTrackedCategories {      

	public function up()
    {
		Schema::table('TrackedCategory', function($table)
		{
			$table->boolean('deleted')->default(0);
		});
	}

	public function down()
    {
		Schema::table('TrackedCategory', function($table)
		{
			$table->drop_column('deleted');
		});
    }

}