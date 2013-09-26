<?php

class ReportDeletedFields {

	public function up()
    {
		Schema::table('ReportTemplateField', function($table)
		{
			$table->boolean('deleted')->default(0);
		});

		Schema::table('ReportFilter', function($table)
		{
			$table->boolean('deleted')->default(0);
		});

		Schema::table('ReportTemplate', function($table)
		{
			$table->boolean('deleted')->default(0);
		});
	}

	public function down()
    {
		Schema::table('ReportTemplateField', function($table)
		{
			$table->drop_column('deleted');
		});
		Schema::table('ReportFilter', function($table)
		{
			$table->drop_column('deleted');
		});
		Schema::table('ReportTemplate', function($table)
		{
			$table->drop_column('deleted');
		});

    }

}