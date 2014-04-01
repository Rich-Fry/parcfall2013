<?php

class PersonnelFormType extends Eloquent
{
	public static $table = 'PersonnelFormType';
	public function get_formTitle($id)
	{
		return  PersonnelFormType::select('PersonnelFormType.formTitle as formTitle')->where('PersonnelFormType.id','=',$id)->get();
	}
	
	public function personnelForm()
	{
		return $this->belongs_to('PersonnelForm');
	}
	
		public function trackedItems()
	{
		return $this->belongs_to('TrackedItem');
	}
}