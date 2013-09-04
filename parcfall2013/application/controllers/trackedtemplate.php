<?php

class TrackedTemplate_Controller extends Base_Controller 
{
	public function __construct() {
		$this->filter( 'before', 'auth' );
		parent::__construct();
	}
	
	//function to create a tracked template
	public function action_create() {
		if(!Auth::user()->can('categoryCreation')){
			Session::flash('errors', 'You don\'t have the necessary privileges to create tracked templates.');
			return Response::error('403');
		}
		//rules to compare and validate with
		$rules = array(
			'templateName'		  => 'required|match:/[A-z]*/|max:50|min:1',
			'templateDescription' => 'match:/[A-z]*/|max:200',
			'trackedcategory_ID'		  => 'required'
			);

		//get data
		$data = array(
			'templateName'			=> e(Input::get('templateName')),
			'templateDescription'	=> e(Input::get('templateDescription')),
			'trackedcategory_ID'			=> e(Input::get('categoryID')),
		);
		//get fields
		$fields = Input::get('fields');

		//compare and validate
		$v = Validator::make($data, $rules);

		//if validation fails
		if($v->fails())
		{
			Session::flash('errors', 'There was a problem validating your tracked template, please try again. validator failed:'.json_encode($v->errors));
			return Response::error('400');
		}

		//else validation succeeds
		else{
			try{
				$tt = TrackedTemplate::create($data);
				//if fields is not empty
				if(count($fields)>0){
					$fieldRules = array(
							'fieldName'		  => 'required|match:/[A-z]*/|max:50|min:1'
							);
							
					//validate fields
					foreach ($fields as $field) {
						$fieldValidator = Validator::make($field, $fieldRules);
						if($fieldValidator->fails())
							return 'There was a problem validating your tracked template fields, please try again. validator failed:'.json_encode($fieldValidator->errors);
					}
					//save fields
					$tt->templateFields()->save($fields);
					$tt->templateFields;
				}
				return Response::eloquent($tt);
			}
			catch(Exception $e){
				return 'There was a problem creating your tracked template, please try again. Errors:'.json_encode($e->getMessage());
				// return Response::error('403');
			}
		}
	}
	
	//function to edit a tracked template
	public function action_edit($id) {
		//Authenticate the user
		if(!Auth::user()->can('categoryCreation')){
			Session::flash('errors', 'You don\'t have the necessary privileges to create tracked templates.');
			return Response::error('403');
		}
		//rules for validation
		$rules = array(
			'templateName'		  => 'required|match:/[A-z]*/|max:50|min:1',
			'templateDescription' => 'match:/[A-z]*/|max:200',
			);
		
		//get input data
		$data = array(
			'templateName'			=> e(Input::get('templateName')),
			'templateDescription'	=> e(Input::get('templateDescription')),
		);
		//get fields
		$fields = Input::get('fields');

		//validate the data with the rules
		$v = Validator::make($data, $rules);

		//if validation fails
		if($v->fails())
		{
			Session::flash('errors', 'There was a problem validating your tracked template, please try again. validator failed:'.json_encode($v->errors));
			return Response::error('400');
		}
		
		//else validation succeeds
		else{
			try{
				$tt = TrackedTemplate::find($id);
				$tt->fill($data)->save();
				$fieldRules = array(
						'fieldName' => 'required|match:/[A-z]*/|max:50|min:1'
						);
				foreach ($fields as $field) {
					$fieldValidator = Validator::make($field, $fieldRules);
					if($fieldValidator->fails())
						return 'There was a problem validating your tracked template fields, please try again. validator failed:'.json_encode($fieldValidator->errors);
					if (array_key_exists('id', $field)) {
						//save 
						TrackedTemplateField::find($field['id'])->fill($field)->save();
					} else{
						//insert new field
						$ttf = new TrackedTemplateField($field);
						$tt->templateFields()->insert($ttf);
					}
				}
				return Response::eloquent($tt);
			}
			catch(Exception $e){
				Session::flash('errors','There was a problem creating your tracked template, please try again. Errors:'.json_encode($e->getMessage()));
				return Response::error('500');
			}
		}
	}
	
	//delete fields for tracked template
	public function action_deleteField($id)
	{
		//Authenticate user
		if(!Auth::user()->can('categoryCreation')){
			Session::flash('errors', 'You don\'t have the necessary privileges to create tracked templates.');
			return Response::error('403');
		}else{
			try{
				//delete the field
				TrackedTemplateField::find($id)->delete();
				return json_encode(array('success'=>'true'));
			}catch(Exception $e){
				Session::flash('errors', 'There was a problem deleting your tracked template field, please try again. Errors:'.json_encode($e->getMessage()));
				return Response::error('500');
			}
		}
	}
}