<?php

class CreateTrackedTemplate {    

	public function up()
    {
		Schema::create('TrackedTemplate', function($table) {
			$table->increments('id');
			$table->string('templateName');
			$table->string('templateDescription');
			$table->integer('trackedcategory_id')->unsigned();
			$table->boolean('active')->default(0);
			$table->timestamps();
		});
		Schema::create('TrackedTemplateField', function($table) {
			$table->increments('id');
			$table->string('fieldName');
			$table->string('fieldDescription')->nullable();
			$table->string('fieldValidation')->nullable();
			$table->string('fieldType')->default('string');
			$table->integer('trackedtemplate_id')->unsigned();
			$table->timestamps();
		});
		Schema::create('TrackedItemField', function($table) {
			$table->increments('id');
			$table->string('response');
			$table->integer('trackeditem_id')->unsigned();
			$table->integer('trackedtemplatefield_id')->unsigned();
			$table->timestamps();
		});
    }    

	public function down()
    {
		Schema::drop('TrackedTemplate');
		Schema::drop('TrackedTemplateField');
		Schema::drop('TrackedItemField');
    }

}