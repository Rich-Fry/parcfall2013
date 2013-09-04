<?php

class TrackedCategory extends Eloquent 
{
	public static $table = 'TrackedCategory';
	public function items()
	{
		return $this->has_many('TrackedItem');
	}
	public function template()
	{
		return $this->has_one('TrackedTemplate');
	}
	public function get_activeItems()
	{
		return TrackedItem::where('deleted', '=', '0')->where('trackedcategory_id', '=', $this->get_attribute('id'))->get();
	}
}