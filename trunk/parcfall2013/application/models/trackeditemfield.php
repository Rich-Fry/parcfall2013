<?php

class TrackedItemField extends Eloquent 
{
	public static $table = 'TrackedItemField';
	public function item()
	{
		return $this->belongs_to('trackedItem');
	}
	public function templateField()
	{
		return $this->belongs_to('TrackedTemplateField','trackedtemplatefield_id');
	}
}