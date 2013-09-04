<?php

class TrackedCategory_Controller extends Base_Controller 
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
			$ti = TrackedCategory::with(array('template','template.templateFields'))->where('deleted','=',$archived)->where('categoryName','LIKE','%'.$needle.'%')->or_where('id', '=', $needle)->get();
		} else {
			$ti = TrackedCategory::with(array('template','template.templateFields'))->where('deleted','=',$archived)->get();
		}
		return Response::eloquent($ti);
	}
	
	//function to view tracked categories
	public function action_manage()
	{
		//if the user has authority to add or edit tracked categories; else go to the manage page
		if(Auth::user()->can('categoryCreation')){
			$tc = TrackedCategory::with(array('template','template.templateFields'))->where('deleted', '=', 0)->get();
			$ac = TrackedCategory::with(array('template','template.templateFields'))->where('deleted', '=', 1)->get();
			//array for tracked categories and archived categories
			$data = array(
				'trackedcategories' => $tc,
				'archivedcategories' => $ac, 
				);
			//view the form of tracked categories and archived categories.
			$this->layout->content = View::make('trackedcategory.manage',$data);	
		}else{
			Session::flash('errors', 'You don\'t have permission to create or edit tracked categories');
			return Redirect::to('account/manage');
		}
	}
	
	//function for creating a tracked category
	public function action_create()
	{
		//array for creating the rules or regular expression to create the tracked category
		$rules = array(
			'categoryName'		  => 'required|match:/[A-z]*/|max:50|min:1',
			'categoryDescription' => 'required|match:/[A-z]*/|max:200',
			//'itemExpiration'  => 'required|match:/[0-1]',
			// 'url'             => 'required|match:/[A-z]*/|max:200',
		);
		
		//get the information from the fields and input them into the array $data
		$data = array(
			'categoryName'			=> e(Input::get('categoryName')),
			'categoryDescription'	=> e(Input::get('categoryDescription')),
		);
		if(!is_null(Input::get('url'))){
			$data['itemUrl']=e(Input::get('url'));
		}
		if(!is_null(Input::get('itemExpiration'))){
			$data['itemExpiration']=e(Input::get('itemExpiration'));
		}
		// return json_encode($data);
		
		//validate the data entered with the rules
		$v = Validator::make($data, $rules);
		
		//if the validation fails, then display error
		if($v->fails())
		{
			Session::flash('errors', 'There was a problem creating your Tracked Item, please try again. Errors:'.json_encode($v->errors));
			return "Failure validating item, errors: ".json_encode($v->errors);
		}
		
		//create the tracked category
		else{
			try{
				
				$e = TrackedCategory::create($data);
				return json_encode(array('success'=>true));
			}
			catch(Exception $e){
				Session::flash('errors', 'There was a problem creating your Tracked Item, please try again. Errors:'.json_encode($v->errors));
				return "Failure creating item, errors: ".json_encode($e->getMessage());
			}
		}
	}
	
	
	//funcion to edit a tracked category. This function is very similar to the action_create function and accomplishes the same thing
	public function action_edit($id)
	{
		$rules = array(
			'categoryName'		  => 'required|match:/[A-z]*/|max:50|min:1',
			'categoryDescription' => 'required|match:/[A-z]*/|max:200',
		);
		$data = array(
			'categoryName'			=> e(Input::get('categoryName')),
			'categoryDescription'	=> e(Input::get('categoryDescription')),
		);

		$v = Validator::make($data, $rules);
		
		if($v->fails())
		{
			Session::flash('errors', 'There was a problem creating your Tracked Item, please try again. Errors:'.json_encode($v->errors));
			return "Failure validating item, errors: ".json_encode($v->errors);
		}

		else{
			try{
				//update the tracked category
				$e = TrackedCategory::find($id)->fill($data)->save();
				return json_encode(array('success'=>true));
			}
			catch(Exception $e){
				Session::flash('errors', 'There was a problem creating your Tracked Item, please try again. Errors:'.json_encode($e->getMessage()));
				return "Failure saving item, errors: ".json_encode($e->getMessage());
			}
		}
	}
	
	
	//function to unarchive (undelete) a tracked category. 
	public function action_unarchive($id)
	{
		//only Admin or Super Admin
		if(Auth::user()->is('admin') OR Auth::user()->is('Super Admin') )
		{
			$undeleteItems = e(Input::get('undeleteItems'));
			$e = TrackedCategory::find($id);
			$e->deleted = 0;
			$e->save();
			//undelete tracked Items in the category
			if($undeleteItems=='true'){
				$items = $e->items;
				for ($i=0; $i < count($items); $i++) { 
					$items[$i]->deleted = 0;
					$items[$i]->save();
				}
			}
			return json_encode(array('success'=>true));
		}
		else
		{
			return json_encode(array('success'=>false));
		}	
	}
	
	//function to archive (delete) a tracked category. Very similar to action_unarchive function
	public function action_archive($id)
	{
		if(Auth::user()->is('admin') OR Auth::user()->is('Super Admin') )
		{
			$e = TrackedCategory::find($id);
			$e->deleted = 1;
			$e->save();
			$items = $e->items;
			//archive tracked items in the category
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