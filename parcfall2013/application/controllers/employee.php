<?php

class Employee_Controller extends Base_Controller {
	public function __construct() {
		$this->filter( 'before', 'auth' );
		parent::__construct();
	}
	public function action_createForm()
	{
		if(!Auth::user()->can('employeeCreation')){
			Session::flash('errors', 'You don\'t have the necessary privileges to create employees/clients.');
			return Redirect::to('account/manage');
		}
		$p = Program::where_not_in('programName', array('General', 'General Employee', 'General Client'))->get();
		$data =  array('programs' => $p );
		$this->layout->content = View::make('employee.create',$data);
	}
	public function action_create() {
		if(!Auth::user()->can('employeeCreation')){
			Session::flash('errors', 'You don\'t have the necessary privileges to create employees/clients.');
			return Redirect::to('account/manage');
		}
		$rules = array(
			'firstName' => 'required|match:/[A-z]*/|max:32|min:1',
			'lastName' => 'required|match:/[A-z]*/|max:32|min:1',
			'client' => 'required|match:/[0-1]/',
	//		'program' => 'required',
			);

		$data = array(
			'firstName' => e(Input::get('firstname')),
			'lastName' => e(Input::get('lastname')),
			'client'	=> e(Input::get('client')),
			'deleted'	=>0,
			);
		$p = Input::get('program');
		$v = Validator::make($data, $rules);

		if($v->fails())
		{
			Session::flash('errors', 'There was a problem creating your employee, please try again. validator failed:'.json_encode($v->errors));
			return Redirect::to('employee/createForm');
		}

		else{
			if(!$p){
				Session::flash('errors', 'Program is required.');
				return Redirect::to('employee/createForm');
			}
			array_push($p, 1);
			array_push($p, ($data['client']==0?2:3));
			try{

				$e = Employee::create($data);
				foreach ($p as $program) {
					$e->programs()->attach(Program::find($program));
				}

				//Store the information needed to save the person's first name in the questionresponse table
				$questionID = FormQuestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'First Name')->get();
				$responseFirstName = array(
					'formquestion_id' => $questionID[0]->id,
					'response' => e(Input::get('firstname')),
					'dataform_id'	=>1,
					'employee_id'	=>$e->id,
					);

				//Store the information needed to save the person's last name in the questionresponse table
				$questionID = FormQuestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Last Name')->get();
				$responseLastName = array(
					'formquestion_id' => $questionID[0]->id,
					'response' => e(Input::get('lastname')),
					'dataform_id'	=>1,
					'employee_id'	=>$e->id,
					);

				//Then save the names into the table
				QuestionResponse::create($responseFirstName);
				QuestionResponse::create($responseLastName);

				return Redirect::to('employee/edit/'.$e->id);
			}
			catch(Exception $e){
				Session::flash('errors', 'There was a problem creating your employee, please try again. Errors:'.json_encode($e->getMessage()));
				return Redirect::to('employee/createForm');
			}
		}
	}

	//archive an employee that is inactive
	public function action_archive($id) {
		if(Auth::user()->is('admin') OR Auth::user()->is('Super Admin') ){
			$e = Employee::find($id);
			$e->deleted = 1;
			$e->save();
			return true;
		}
		return json_encode(array('success'=>false,'error'=>'You don\'t have the privileges necessary to archive employees or clients.'));
	}
	public function action_unarchive($id)
	{
		if(Auth::user()->is('admin') OR Auth::user()->is('Super Admin') )
		{
			$e = Employee::find($id);
			$e->deleted = 0;
			if($e->program->deleted==1){
				return json_encode(array('success'=>false,'error'=>"This employee or client's program has been archived, unarchive the program before unarchiving employee/client."));

			}
			$e->save();
			return json_encode(array('success'=>true));
		}
		else
		{
			return json_encode(array('success'=>false));
		}
	}
	public function action_find( $clientFlag ) {
		$criteria = e( Input::get( 'criteria' ) );
		if ( !is_null( $criteria ) and strlen( $criteria ) > 0 ) {
			$needle = e( $criteria );
			$u = Employee::with('programs')->where( 'client', '=', intval( $clientFlag ) )->where( function ( $query ) use ($needle){
					$query->where( 'firstname', 'LIKE', "%" . $needle . "%" );
					$query->or_where( 'lastname', 'LIKE', "%" . $needle . "%" );
				} )->where('deleted','=',0)->get();
		} else {
			$u = Employee::with('programs')->where( 'client', '=', intval( $clientFlag ) )->where('deleted','=',0)->get();
		}
		//$data= array("columns"=>array("Name", "Programs"), "data"=>$data);
		
		//ChromePhp::warn('Hit the main part of the function.');
		//ChromePhp::warn($u);
		$ru = array();
		foreach ($u as $key => $value) {
			//ChromePhp::warn('$value');
			//ChromePhp::warn($value);
			// This is what is broken right now
			$programs = $value->get_programs();
			//ChromePhp::warn('$programs');
			//ChromePhp::warn($programs);
			
			if (!is_null($programs))
			{
				//ChromePhp::warn('Programs not null.');
				$haveadded = FALSE;
				foreach ($programs as $key1 => $value1) {
					//ChromePhp::warn('$value1');
					//ChromePhp::warn($value1);
					if ($haveadded == FALSE)
					{
						//ChromePhp::warn('Not Added Yet');
						if (Auth::user()->can(Auth::getRequiredViewRoles($value1)))
						{
							//ChromePhp::warn('Allowed!');
							$ru[] = $value;
							$haveadded = TRUE;
							//ChromePhp::warn('Done Adding.');
						}
					}
					//ChromePhp::warn('End of permission foreach');
				}
				//ChromePhp::warn('Exiting if');
			}
			//ChromePhp::warn('Exiting user foreach!');
		}
		
		//ChromePhp::warn('DONE!!');
		//ChromePhp::warn($ru);
		return Response::eloquent($ru);
	}

	// public function action_index() {

	// 	$this->layout->content = View::make( 'employee.manage' );
	// }

	//function to edit employee info in a form
	public function action_edit( $id ){
		if ( Auth::can('employeeCreation') ) {
			$u=Employee::find($id);
			// $u->programs;
			if(!is_null($u)){
			$p = $u->programs;
			$u->forms;
			foreach($p as $program){
				$f = $program->forms;
				foreach ($f as $form) {
					$form->questions;
				}
			}
			$data = array(
				'employee'=>$u,
				'programs'=>$p,
			);
			$this->layout->content = View::make( 'employee.edit', $data );
			}else{
				return "user doesn't exist";
			}
		}else {
			Session::flash( 'errors', 'You don\'t have permission to edit employees information' );
			return Redirect::to( 'account/manage' );
		}
	}

	//function to save the edited form
	public function action_saveForm()
	{
		$e = Employee::find(e(Input::get('employeeID')));
		$firstNameId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'First Name')->get();
		$lastNameId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Last Name')->get();
		$questions = Input::get('questions');
		$responses = array();
		if(isset($questions) && count($questions) > 0)
		foreach ($questions as $q) {
			if(array_key_exists('questionid', $q) && array_key_exists('response', $q) && strlen($q['response']) > 0)
			{
				array_push($responses, array('formquestion_ID' => $q['questionid'], 'response' => $q['response'], 'dataform_id' => e(Input::get('formID'))));
				
				if($q['questionid'] == $firstNameId[0]->id){
					$e->firstName = $q['response'];
				}
				if($q['questionid'] == $lastNameId[0]->id){
					$e->lastName = $q['response'];
				}
			}
		}

		//Save it off into the other table too
		$e->save();//This doesn't seem to be getting called when I think it should

		return $e->formResponses()->save($responses);
	}

     //function to validate addresses
     public function action_validateAddress(){
          $v = new addressValidation;
		$address = array(
			"Address1"=>Input::get('Address1', null),
			"Address2"=>Input::get('Address2', null),
			"City"=>Input::get('City', null),
			"State"=>Input::get('State', null),
			"Zip5"=>Input::get('Zip', null),
			"Zip4"=>""
		);

		if(!is_null($address['Address1']) && !is_null($address['Address2']) && !is_null($address['City']) && !is_null($address['State']) && !is_null($address['Zip5'])){
	          return json_encode($v->validate($address));
		}else{
			return json_encode(array("Error"=>"Wrong parameters passed to server"));
		}


	 }
}