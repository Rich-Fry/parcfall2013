<?php

class Program extends Eloquent 
{
	public static $table = 'Program';
	public function forms()
	{
		return $this->has_many_and_belongs_to('DataForm', 'FormProgram' ,'program_id', 'dataform_id');
	}
	public function employees()
	{
		return $this->has_many_and_belongs_to('Employee', 'employeeProgram', 'program_id', 'employee_id');
	}
}