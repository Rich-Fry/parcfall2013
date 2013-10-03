<?php

class Comboboxfield extends Eloquent 
{
	public static $table = 'comboboxfields';
	public static function states($id)
	{ 
		$comboValue = DB::$table('comboValue')->lists('comboValue')->where('formquestion_id', $id);
		return $comboValue;
	}

} 