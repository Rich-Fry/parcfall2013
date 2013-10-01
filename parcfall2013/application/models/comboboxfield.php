<?php

class Comboboxfield extends Eloquent 
{
	public static $table = 'comboboxfields';
	public function states()
	{
		$comboValue = Comboboxfield::lists('comboValue', 'id')->where('formquestion_id', '9');
	//	return View::make('application/views/employee/edit.blade.php')->with('comboValue',$comboValue)->get();
		return $comboValue;
	}

} 