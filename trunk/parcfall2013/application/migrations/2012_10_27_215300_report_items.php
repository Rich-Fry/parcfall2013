<?php

class Report_Items {    

	public function up()
    {
		Schema::create('ReportTemplateField', function($table) {
			$table->increments('id');
			$table->integer('report_id')->unsigned();
			$table->integer('formquestion_id')->unsigned();
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('ReportTemplateField');

    }

}