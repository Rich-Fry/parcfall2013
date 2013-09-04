<?php

class QuestionResponse extends Eloquent 
{
	public static $table = 'QuestionResponse';
	public function question()
	{
		return $this->belongs_to('FormQuestion');
	}
	public function employee()
	{
		return $this->belongs_to('Employee');
	}
}
