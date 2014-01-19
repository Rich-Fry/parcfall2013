<?php

class encore {    

	public function up()
    {
		Schema::create('encore', function($table) {
			$table->increments('id');
            $table->integer('employee_id')->unsigned();
			$table->decimal('compensation', 15, 2)->unsigned();
            $table->decimal('non_compensation', 15, 2)->unsigned();
            $table->decimal('paid_hours', 15, 2)->unsigned();
            $table->decimal('productivity', 8, 6)->unsigned();
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('encore');
    }

}