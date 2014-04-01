<?php

class PersonnelForm extends Eloquent 
{
	public static $table = 'PersonnelForm';
	public function employee()
	{
		return $this->belongs_to('Employee');
	}

	public function formTitles()
	{
		return $this->has_many('PersonnelFormType');
	}
}