<?php

class Comboboxfield extends Eloquent
{

	public static function getCombo($id)
	{
		return  Comboboxfield::select('comboboxfields.comboValue as id')->where('comboboxfields.formQuestion_id','=',$id)->get();
	}
	public static function getDefault($id)
	{
				return  Comboboxfield::select('comboboxfields.defaultValue as id')->where('comboboxfields.formQuestion_id','=',$id)->get();
	}

	public function formQuestion()
	{
		return $this->has_many('formquestion');
	}

	public function role()
	{
		return $this->has_many('roles');
	}

}