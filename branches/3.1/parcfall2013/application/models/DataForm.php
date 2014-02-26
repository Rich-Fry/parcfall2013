<?php

class DataForm extends Eloquent 
{
	public static $table = 'Form';
	public function program()
	{
		return $this->has_many_and_belongs_to('Program', 'FormProgram', 'dataform_id', 'program_id');
	}
	public function questions()
	{
		return $this->has_many('FormQuestion')->order_by("view_order", "asc");
	}
}