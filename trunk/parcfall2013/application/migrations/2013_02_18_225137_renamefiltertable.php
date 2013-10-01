<?php

class RenameFilterTable {    

	public function up()
    {
    	Schema::drop('ReportFilter');
		Schema::create('ReportFieldFilter', function($table) {
			$table->increments('id');
			$table->string('filterCriteria');
			$table->boolean('andOrFlag')->default(0);
			$table->integer('reportfield_id')->unsigned();
			$table->boolean('deleted')->default(0);
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('ReportFieldFilter');
		Schema::create('ReportFilter', function($table) {
			$table->increments('id');
			$table->string('filterCriteria');
			$table->boolean('andOrFlag')->default(0);
			$table->integer('reportfield_id')->unsigned();
			$table->boolean('deleted')->default(0);
			$table->timestamps();
		});
    }

}