<?php

class Employee extends Eloquent 
{
	public static $table = 'Employee';
	public function get_trackedItems()
	{
		return TrackedItem::with(array('category',
						'category.template', 
						'fields', 
						'fields.templateField'))->where('employee_id','=',$this->id)->where('deleted','=',0)->get();
	}
	public function get_archivedItems()
	{
		return TrackedItem::with(array('category',
						'category.template', 
						'fields',
						'fields.templateField'))->where('employee_id','=',$this->id)->where('deleted','=',1)->get();
	}
	public function items()
	{
		return $this->has_many('TrackedItem');
	}
	public function formResponses()
	{
		return $this->has_many('QuestionResponse')->order_by('created_at');
	}
	public function programs()
	{
		return $this->has_many_and_belongs_to('Program','EmployeeProgram', 'employee_id', 'program_id');
	}
	public function get_programs()
	{
		// You should be able to get this from the function above by getting the user with programs
		// ... kudos to you if you figure it out... you no longer need this function
		$programs = DB::table('Program')
			->join('EmployeeProgram', 'Program.id', '=', 'EmployeeProgram.program_id')
			->join('Employee', 'EmployeeProgram.employee_id', '=', 'Employee.id')
			->where('Employee.id', '=', $this->id)
			->select('Program.*')
			->get();
		return $programs;
	}
	public function get_questionIDs()
	{
		$responses = $this->formResponses;
		$qArray = array();
		foreach ($responses as $response) {
			array_push($qArray, $response->formQuestion_ID);
		}
		return $qArray;
	}
	public function get_forms()
	{
		$responses = $this->formResponses;
		$formArray = array();
		foreach ($responses as $response) {
			$curID = $response->dataform_id;
			if(!array_key_exists($curID, $formArray)){
				$form = DataForm::find($curID);
				if(!is_null($form)){
					$temp = array(
							'name' => $form->formname,
							'description' => $form->formdescription,
							'responses' => array(),
						);
					$formArray[$curID] = $temp;
				}
			}
			$formArray[$curID]['responses'][$response->formquestion_id] = $response->response;
			// array_push($formArray[$curID]['responses'][$response->formquestionid], $response->response);
			// $response->
		}
		return $formArray;
	}
}