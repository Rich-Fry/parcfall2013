<?php

class User_Controller extends Base_Controller 
{
	public function __construct() {
		// $this->filter( 'before', 'csrf' )->only( array( 'create', 'edit' ) );
		$this->filter( 'before', 'auth' );
		parent::__construct();
	}
	public function action_createForm()
	{
		$this->layout->content = View::make('user.create');
	}
	
	//function to create a user
	public function action_create()
	{
		//rules to validate
		$rules = array(
			'username' => 'required|min:3|max:32|email',
			'password' => 'required|match:/[A-z0-9 _-]*/|max:32|min:6',
			);
		//get data
		$data = array(
			'username' => e(Input::get('username')),
			'password' => e(Input::get('password')),
			'email' => e(Input::get('username')),
			);
		//Authenticate user and get verified and role
		if(Auth::user()->can('userCreation')){
			if(!is_null(Input::get('verified')))
				$data['verified'] = Input::get('verified');
			if(!is_null(Input::get('role'))){
				$data['role_id'] = Input::get('role');
			}
		} 
		//else get role of non-user creator
		else {
			$data['role_id'] = Verify\Models\Role::where('name','=','unverified')->first()->id;
		}
		
		//validate data
		$v = Validator::make($data, $rules);

		//if validation fails
		if($v->fails())
		{
			if(!Auth::user()->can('userCreation')){
				Session::flash('errors', 'There was a problem creating the account, please try again errors: '.json_encode($v->errors));
				return Redirect::to('user/createForm');
			}
			else{
				header('HTTP/1.1 400 Invalid Fields Submitted');
		        header('Content-Type: application/json');
				die(json_encode(array('message' => 'There fields passed were incorrect, please try again', 'code' => 400)));
			} 
		}
		//else validation succeeds
		else{
			try{
				//Create user
				$u = Verify\Models\User::create($data);
				if(!Auth::user()->can('userCreation')){
					Session::flash('info', 'Your account has been created.  The administrator needs to approve your account before you will be able to login.');
					return Redirect::to('home/index');
				} else {
					return json_encode(array('success'=>true));
				}
			}
			catch(Exception $e){
				header('HTTP/1.1 500 Internal Server Error');
		        header('Content-Type: application/json');
				die(json_encode(array('message' => 'There was a problem creating your account, please try again errors2:'.json_encode($e->getMessage()), 'code' => 500)));
			}
		}

	} 
		
		
	public function action_read($delFlag)
	{
		if(Auth::user()->can('userCreation')){
			$archived = e($delFlag);
			$needle = e( Input::get( 'criteria' ) );
			if ( !is_null( $needle ) and strlen( $needle ) > 0 ) {
				$pr = Verify\Models\User::where('disabled','=',$archived)->where('username','LIKE','%'.$needle.'%')->or_where('id', '=', $needle)->get();
			} else {
				$pr = Verify\Models\User::where('disabled','=',$archived)->get();
			}
			return Response::eloquent($pr);
		} else{
			header('HTTP/1.1 500 Internal Server Error');
	        header('Content-Type: application/json');
			die(json_encode(array('message' => "You don't have permission to view users", 'code' => 500)));
		}
	}
	
	//function to show form to manage users
	public function action_manage()
	{
		if(Auth::user()->can('userCreation') || Auth::user()->can('userDeletion')){
			$u = Verify\Models\User::where('disabled', '=', 0)->get();
			$du = Verify\Models\User::where('disabled', '=', 1)->get();
			$r = Verify\Models\Role::where('deleted', '=', 0)->get();
			$data = array(
				'users' => $u,
				'disabledusers' => $du, 
				'roles' => $r
				);
			$this->layout->content = View::make('User.manage',$data);	
		}else{
			Session::flash('errors', 'You don\'t have permission to create or edit Users');
			return Redirect::to('account/manage');
		}
	}
	//function to make a user unarchived or visible
	public function action_unarchive($id)
	{
		if(Auth::user()->can('userCreation') )
		{
			$u = Verify\Models\User::find($id);
			$u->disabled = 0;
			$u->save();
			return json_encode(array('success'=>true));
		}
		else
		{
			header('HTTP/1.1 500 Internal Server Error');
	        header('Content-Type: application/json');
			die(json_encode(array('message' => "You don't have permission to undelete users accounts", 'code' => 500)));
		}	
	}
	/* This delete funtion does not delete the user, it changes the disabled field to 1 (true) and hides the user from view*/
	public function action_archive($id)
	{
		if(Auth::user()->id == $id)
		{
			$u = Verify\Models\User::find($id);
			$u->disabled = 1;
		
			$u->save();
			return Redirect::to('account/logout');
		}
		else
		{
			if(Auth::user()->can('userDeletion')){
				$u = Verify\Models\User::find($id);
				$u->disabled = 1;
				$u->save();
				return json_encode(array('success'=>true));
			} else{
				header('HTTP/1.1 500 Internal Server Error');
		        header('Content-Type: application/json');
				die(json_encode(array('message' => "You don't have permission to delete other users accounts", code => 500)));
			}
		}

	}
	
	//function to show the form to edit a user.
	public function action_editForm($empid)
	{
		if(Auth::user()->id === $empid || Auth::user()->can('userCreation'))
			$this->layout->content = View::make('user.edit', array('user'=>Verify\Models\User::find($empid), 'roles'=>Verify\Models\Role::all()));
	}
	
	//function to save the edited user
	public function action_edit($empid)
	{
		$rules = array();
		$data = array();
		if(!is_null(Input::get('password')) and strlen( Input::get('password') ) > 0){
			$rules['password'] = 'required|match:/[A-z0-9 _-]*/|max:32|min:6';
			$data['password'] = Input::get('password');
		}
		if(!is_null(Input::get('role')) && strlen(Input::get('role'))>0) {
			$data['role_id'] = Input::get('role');
		}
		$v = Validator::make($data, $rules);

		if($v->fails())
		{
			if(Auth::user()->id == $empid){
				Session::flash('errors', 'Password did not match necessary requirements, please try again');
				return Redirect::to('user/edit');
			}
			header('HTTP/1.1 500 Internal Server Error');
	        header('Content-Type: application/json');
			die(json_encode(array('message' => "The fields were not correct, errors: " . json_encode($v->errors), 'code' => 500)));
		}
		else{
			try{
				$u = Verify\Models\User::find($empid)->fill($data)->save();
				if(Auth::user()->id == $empid)
					return Redirect::to('account/manage');
				else
					return json_encode(array('success'=>true));
			}
			catch(Exception $e){
				if(Auth::user()->id == $empid){
					Session::flash('errors', 'There was a problem editing your account please try again.');
					return Redirect::to('account/manage');
				}else{
					header('HTTP/1.1 500 Internal Server Error');
			        header('Content-Type: application/json');
					die(json_encode(array('message' => 'There was a problem editing that account, please try again. errors:'.json_encode($e->getMessage()), 'code' => 500)));	
				}			
			}
		}
	}
}