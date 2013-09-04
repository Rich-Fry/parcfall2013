<?php

class Reports {    

	public function up()
    {
		Schema::create('ReportTemplate', function($table) {
			$table->increments('id');
			$table->string('reportName');
			$table->string('reportDescription');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('ReportTemplate');

    }

}