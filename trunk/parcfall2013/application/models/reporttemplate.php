hh<?php
class temp {
		public $response = "N/A";
	}
class ReportTemplate extends Eloquent 
{
	public static $table = 'ReportTemplate';
	public function items()
	{
		return $this->has_many('ReportTemplateField');
	}
	public function get_report()
	{
		$reportItems = $this->items()->get();
		$report = array();
		$emps = Employee::all();
		foreach($emps as $emp){
			$report[$emp->id] = array('employee' => $emp, 'responses'=>array());
		}
		// $report['employees'] = array();
		foreach ($reportItems as $item) {
			// return $item->formQuestion->responses;
			$responses = $item->formQuestion->responses;
			foreach ($responses as $response) {
				$report[$response->employee_id]['responses'][$response->formquestionid]= $response;
			}

			foreach ($report as $obj){
				if(!array_key_exists($item->formquestionid, $obj['responses'])){
					$report[$obj['employee']->id]['responses'][$item->formquestionid]= new temp();
					// $obj['responses'][$item->formquestionid]= "N/A";
				}
			}
			
		}
		// $report['all'] = $reportItems;
		return $report;
	}
	public function questions()
	{
		return $this->has_many_and_belongs_to('FormQuestion', 'ReportTemplateField', 'report_id', 'formQuestion_id');
	}
}