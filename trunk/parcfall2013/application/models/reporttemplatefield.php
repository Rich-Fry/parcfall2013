<?php

class ReportTemplateField extends Eloquent 
{
	public static $table = 'ReportTemplateField';
	public function reporttemplate()
	{
		return $this->belongs_to('ReportTemplate');
	}
	public function filter()
	{
		return $this->has_one('ReportFieldFilter');
	}
	public function formquestion()
	{
		return $this->belongs_to('FormQuestion');
	}
	// public function get_responses()
	// {
	// 	$qid = $this->get_attribute('formQuestionID');
	// }
}