<?php

class Program_Controller extends Base_Controller 
{
	public function __construct() {
		$this->filter( 'before', 'auth' );
		parent::__construct();
	}
	public function action_read($delFlag)
	{
		$archived = e($delFlag);
		$needle = e( Input::get( 'criteria' ) );
		if ( !is_null( $needle ) and strlen( $needle ) > 0 ) {
			$pr = Program::where('deleted','=',$archived)->where('programName','LIKE','%'.$needle.'%')->or_where('id', '=', $needle)->get();
		} else {
			$pr = Program::where('deleted','=',$archived)->get();
		}
		return Response::eloquent($pr);
	}
	public function action_manage()
	{
		if(Auth::user()->can('programCreation')){
			$pr = Program::where('deleted', '=', 0)->get();
			$ap = Program::where('deleted', '=', 1)->get();
			$data = array(
				'programs' => $pr,
				'archivedprograms' => $ap, 
				);
			$this->layout->content = View::make('program.manage',$data);	
		}else{
			Session::flash('errors', 'You don\'t have permission to create or edit programs');
			return Redirect::to('account/manage');
		}
	}
	public function action_create()
	{
		$rules = array(
			'programName'		  => 'required|match:/[A-z]*/|max:50|min:1',
			'programDescription' => 'required|match:/[A-z]*/|max:200',
		);
		$data = array(
			'programName'			=> e(Input::get('programName')),
			'programDescription'	=> e(Input::get('programDescription')),
		);
		$v = Validator::make($data, $rules);
		
		if($v->fails())
		{
			Session::flash('errors', 'There was a problem creating that program, please try again. Errors:'.json_encode($v->errors));
			return "Failure validating item, errors: ".json_encode($v->errors);
		}

		else{
			try{
				
				$e = Program::create($data);
				return json_encode(array('success'=>true));
			}
			catch(Exception $e){
				Session::flash('errors', 'There was a problem creating that program, please try again. Errors:'.json_encode($v->errors));
				return "Failure creating program, errors: ".json_encode($e->getMessage());
			}
		}
	}
	public function action_edit($id)
	{
		$rules = array(
			'programName'		  => 'required|match:/[A-z]*/|max:50|min:1',
			'programDescription' => 'required|match:/[A-z]*/|max:200',
		);
		$data = array(
			'programName'			=> e(Input::get('programName')),
			'programDescription'	=> e(Input::get('programDescription')),
		);

		$v = Validator::make($data, $rules);
		
		if($v->fails())
		{
			Session::flash('errors', 'There was a problem editing that program, please try again. Errors:'.json_encode($v->errors));
			return "Failure validating program, errors: ".json_encode($v->errors);
		}

		else{
			try{
				
				$e = Program::find($id)->fill($data)->save();
				return json_encode(array('success'=>true));
			}
			catch(Exception $e){
				Session::flash('errors', 'There was a problem editing that program, please try again. Errors:'.json_encode($v->errors));
				return "Failure saving program, errors: ".json_encode($v->errors);
			}
		}
	}
	public function action_unarchive($id)
	{
		if(Auth::user()->can('programDeletion') )
		{
			$undeleteEmployees = e(Input::get('undeleteEmployees'));
			$p = Program::find($id);
			$p->deleted = 0;
			$p->save();
			if($undeleteEmployees=='true'){
				$employees = $p->employees;
				for ($i=0; $i < count($employees); $i++) { 
					$employees[$i]->deleted = 0;
					$employees[$i]->save();
				}
			}
			return json_encode(array('success'=>true));
		}
		else
		{
			return json_encode(array('success'=>false));
		}	
	}
	public function action_archive($id)
	{
		if(Auth::user()->can('programDeletion') )
		{
			$e = Program::find($id);
			$e->deleted = 1;
			$e->save();
			$items = $e->employees;
			for ($i=0; $i < count($items); $i++) { 
				$items[$i]->deleted = 1;
				$items[$i]->save();
			}
			return json_encode(array('success'=>true));
		}
		else
		{
			return json_encode(array('success'=>false));
		}	
	}
}