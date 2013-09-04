<?php

class ReportFieldFilter extends Eloquent 
{
	public static $table = 'ReportFieldFilter';
	public function field()
	{
		return $this->belongs_to('ReportTemplateField');
	}
	public function get_connector()
	{
		$flag = $this->getAttribute('andOrFlag');
		if($flag == 0)
			return 'AND';
		else if($flag == 1)
			return 'OR';
		else
			return '';
	}
}