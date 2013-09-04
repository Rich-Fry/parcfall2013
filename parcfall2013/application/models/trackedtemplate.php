<?php

class TrackedTemplate extends Eloquent 
{
	public static $table = 'TrackedTemplate';
	public function category()
	{
		return $this->belongs_to('TrackedCategory');	
	}
	public function templateFields()
	{
		return $this->has_many('TrackedTemplateField');
	}
}