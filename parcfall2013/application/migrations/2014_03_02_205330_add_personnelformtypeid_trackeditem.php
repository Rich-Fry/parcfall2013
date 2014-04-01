<?php

class Add_Personnelformid_Trackeditem {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('TrackedItem', function($table)
		{
			$table->integer('personnelFormType_id')->default(0)->unsigned();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('TrackedItem', function($table)
		{
			$table->drop_column('personnelFormType_id');
		});
	}

}





