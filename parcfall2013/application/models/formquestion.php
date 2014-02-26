<?php

class FormQuestion extends Eloquent 
{
	public static $table = 'FormQuestion';
	public function form()
	{
		return $this->belongs_to('DataForm');
	}
	public function responses()
	{
		return $this->has_many('QuestionResponse');
	}
}
