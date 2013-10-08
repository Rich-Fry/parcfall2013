<?php

class Formquestions {

	public function up()
    {
		Schema::create('FormQuestion', function($table) {
			$table->increments('id');
			$table->integer('dataform_id')->unsigned();
			$table->string('questionText');
			$table->string('questionExample');
		    $table->boolean('required')->default(true);
		    $table->string('validate', 256)->nullable()->default(null);
			$table->timestamps();
	});

    }

	public function down()
    {
		Schema::drop('FormQuestion');

    }

}