<?php

class WorkLocation extends Eloquent 
{
	public static $table = 'worklocation';
	
	public static function getWorkLocations()
	{
		return WorkLocation::select('worklocation.work_location_code as work_location_code,
		 worklocation.primary_work_location_name as primary_work_location_name,
		 worklocation.primary_work_location_zip as primary_work_location_zip,
		 worklocation.primary_work_location_type as primary_work_location_type,
		 worklocation.primary_industry as primary_industry')->get();
	}
}