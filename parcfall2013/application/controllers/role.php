<?php

class Role_Controller extends Base_Controller 
{
	public function __construct() {
		$this->filter( 'before', 'auth' );
		parent::__construct();
	}
	public function action_read($delFlag)
	{
		if(Auth::user()->can('roleCreation')){
			$archived = e($delFlag);
			$needle = e( Input::get( 'criteria' ) );
			if ( !is_null( $needle ) and strlen( $needle ) > 0 ) {
				$ro = Verify\Models\Role::with('permissions')->where('deleted','=',$archived)->where('name','LIKE','%'.$needle.'%')->or_where('id', '=', $needle)->get();
			} else {
				$ro = Verify\Models\Role::with('permissions')->where('deleted','=',$archived)->get();
			}
			return Response::eloquent($ro);
		}else{
			header('HTTP/1.1 500 Internal Server Error');
			header('Content-Type: application/json');
			die(json_encode(array('message' => "You don't have permission to view roles", 'code' => 500)));
		}
	}
	public function action_manage()
	{
		if(Auth::user()->can('roleCreation')){
			$ro = Verify\Models\Role::with('permissions')->where('deleted', '=', 0)->get();
			$ar = Verify\Models\Role::with('permissions')->where('deleted', '=', 1)->get();
			$data = array(
				'roles' => $ro,
				'archivedroles' => $ar,
				'permissions' => Verify\Models\Permission::all(), 
				);
			$this->layout->content = View::make('role.manage',$data);	
		}else{
			Session::flash('errors', 'You don\'t have permission to create or edit roles');
			return Redirect::to('account/manage');
		}
	}
	public function action_create()
	{
		if(Auth::user()->can('roleCreation')){
			$rules = array(
				'name'		  => 'required|match:/[A-z]*/|max:50|min:1',
				'description' => 'match:/[A-z]*/|max:200',
			//'itemExpiration'  => 'required|match:/[0-1]',
			// 'url'             => 'required|match:/[A-z]*/|max:200',
				);
			$data = array(
				'name'			=> e(Input::get('name')),
				'description'	=> e(Input::get('description')),
				'level'			=> 10,
				);
			$privs = Input::get('privs');
		// return json_encode($data);
			$v = Validator::make($data, $rules);
			
			if($v->fails())
			{
				header('HTTP/1.1 500 Internal Server Error');
				header('Content-Type: application/json');
				die(json_encode(array('message' => "Some fields did not validate", 'code' => 500)));
			}

			else{
				try{
					
					$e = Verify\Models\Role::create($data);
					if(is_array($privs) && count($privs)>0){
						foreach ($privs as $priv) {
							$e->permissions()->attach($priv);
						}
					}
					return json_encode(array('success'=>true));
				}
				catch(Exception $e){
					header('HTTP/1.1 500 Internal Server Error');
					header('Content-Type: application/json');
					die(json_encode(array('message' => "There was an unknown error trying to create, try again: " . json_encode($e->getMessage()), 'code' => 500)));
				}
			}
		}else{
			header('HTTP/1.1 500 Internal Server Error');
			header('Content-Type: application/json');
			die(json_encode(array('message' => "You don't have permission to create roles", 'code' => 500)));
		}
	}
	public function action_edit($id)
	{
		$rules = array(
			'name'		  => 'required|match:/[A-z]*/|max:50|min:1',
			'description' => 'match:/[A-z]*/|max:200',
			);
		$data = array(
			'name'			=> e(Input::get('name')),
			'description'	=> e(Input::get('description')),
			);
		$privs = Input::get('privs');
		$v = Validator::make($data, $rules);
		
		if($v->fails())
		{
			header('HTTP/1.1 500 Internal Server Error');
			header('Content-Type: application/json');
			die(json_encode(array('message' => "Some fields were did not validate", 'code' => 500)));
		}

		else{
			try{
				$e = Verify\Models\Role::find($id);
				$e->fill($data)->save();
				if(is_array($privs) && count($privs)>0){
					foreach ($privs as $priv) {
						$e->permissions()->attach($priv);
					}
				}
				return json_encode(array('success'=>true));
			}
			catch(Exception $e){
				header('HTTP/1.1 500 Internal Server Error');
				header('Content-Type: application/json');
				die(json_encode(array('message' => "There was an unknown error trying to edit, try again: " . json_encode($e->getMessage()), 'code' => 500)));
			}
		}
	}
	public function action_unarchive($id)
	{
		if(Auth::user()->can('roleCreation') )
		{
			$undeleteItems = e(Input::get('undeleteItems'));
			$e = Verify\Models\Role::find($id);
			$e->deleted = 0;
			$e->save();
			if($undeleteItems=='true'){
				$items = $e->employees;
				for ($i=0; $i < count($items); $i++) { 
					$items[$i]->deleted = 0;
					$items[$i]->save();
				}
			}
			return json_encode(array('success'=>true));
		}
		else
		{
			header('HTTP/1.1 500 Internal Server Error');
			header('Content-Type: application/json');
			die(json_encode(array('message' => "You don't have permission to unarchive roles", code => 500)));
		}	
	}
	public function action_archive($id)
	{
		if(Auth::user()->can('roleDeletion') )
		{
			$e = Verify\Models\Role::find($id);
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
			header('HTTP/1.1 500 Internal Server Error');
			header('Content-Type: application/json');
			die(json_encode(array('message' => "You don't have permission to archive roles", code => 500)));
		}	
	}
}