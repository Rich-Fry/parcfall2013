<?php

class TrackedItem extends Eloquent 
{
	public static $table = 'TrackedItem';
	public function employee()
	{
		return $this->belongs_to('Employee');
	}
	public function category()
	{
		return $this->belongs_to('TrackedCategory', 'trackedcategory_id');	
	}
	public function fields()
	{
		return $this->has_many('TrackedItemField');
	}
	public function personnelForms()
        {
                return $this->has_many('PersonnelFormType');
        }
	
}