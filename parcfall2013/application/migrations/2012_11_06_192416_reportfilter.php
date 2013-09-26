<?php

class ReportFilter {

	public function up()
    {
		Schema::create('ReportFilter', function($table) {
			$table->increments('id');
			$table->string('filterCriteria');
			$table->boolean('andOrFlag')->default(0);
			$table->integer('reportfield_id')->unsigned();
			$table->timestamps();
	});

    }

	public function down()
    {
		Schema::drop('ReportFilter');

    }

}