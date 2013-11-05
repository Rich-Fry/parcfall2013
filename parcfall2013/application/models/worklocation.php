<?php

class WorkLocation extends Eloquent 
{
	public static $table = 'worklocation';
	
	public static function getWorkLocations()
	{
		return DB::query('select * from worklocation');
	}
}