<?php

class TrackedTemplateField extends Eloquent 
{
	public static $table = 'TrackedTemplateField';
	public function template()
	{
		return $this->belongs_to('TrackedTemplate');
	}
	public function responses()
	{
		return $this->has_many('TrackedItemField');
	}
}