<?php

class DisabilityCategory extends Eloquent 
{
	public static $table = 'disabilitycategory';
	
	public static function getDisabilityCategories()
	{
		return DisabilityCategory::select('disabilitycategory.npa_disability_category as npa_disability_category,
		 disabilitycategory.ers_disability_category as ers_disability_category')->get();
	}
}