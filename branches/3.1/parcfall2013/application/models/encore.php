<?php

class Encore extends Eloquent 
{
	public static $table = 'encore';
	
	public function employee()
        {
                return $this->belongs_to('Employee');
        }

}
