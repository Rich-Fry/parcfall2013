<?php

class TrackedItem_Controller extends Base_Controller 
{
	public function __construct() {
		$this->filter( 'before', 'auth' );
		parent::__construct();
	}
	//look employee find function
	public function action_create()
	{
		//rules or regular expressions to check the input in the fields
		$rules = array(
			'itemName'		  => 'required|match:/[A-z]*/|max:50|min:1',
			'itemDescription' => 'match:/[A-z]*/|max:200',
		);
		
		//get the data from the fields and put the info in the $data array
		$data = array(
			'employee_id'		=> e(Input::get('employeeID')),
			'itemName'			=> e(Input::get('itemName')),
			'itemDescription'	=> e(Input::get('itemDescription')),
			'trackedcategory_id'		=> e(Input::get('itemCategory')),
		);
		if(count(Input::file())>0 && strlen(Input::get('newFile'))>0){
			$files = Input::file();
			Input::upload('file', 'public/uploads/files', $files['file']['name']);
			$data['itemurl'] = "/uploads/files/".$files['file']['name'];
		}
		
		if(strlen($data['trackedcategory_id'])==0){
			$data['trackedcategory_id'] = 0;
		}
		$fields = json_decode(Input::get('fields'));
		if(!is_null(Input::get('url'))){
			$data['itemUrl']=e(Input::get('url'));
		}
		if(strlen(Input::get('itemExpiration'))>0){
			$itemExpiration = Input::get('itemExpiration');
		}
		// return json_encode($data);
		//validate the data from the fields to the rules
		$v = Validator::make($data, $rules);
		//if the information fails, then error message
		if($v->fails())
		{
			header('HTTP/1.1 500 Internal Server Error');
	        header('Content-Type: application/json');
			die(json_encode(array('message' => "Validation failed", "code" => 500)));
		}
		
		//create the tracked item
		else{
			try{
				$ti = TrackedItem::create($data);
				if(isset($itemExpiration)){
					$ti->itemExpiration = DateTime::createFromFormat("Y-m-d H:i:s",date("Y-m-d H:i:s",strtotime($itemExpiration)));
					$ti->save();
				}
				//1 or more fields
				if(count($fields)>0){
					//rules for the fields
					$fieldRules = array(
							'response'		  => 'required|match:/[A-z]*/|max:200|min:1',
							'trackedtemplatefield_id'=> 'required'
							);
					for ($i=0; $i < count($fields); $i++) { 
						$fields[$i] = (array)$fields[$i];
						$fieldValidator = Validator::make($fields[$i], $fieldRules);
						if($fieldValidator->fails()){
							header('HTTP/1.1 500 Internal Server Error');
					        header('Content-Type: application/json');
							die(json_encode(array('message' => 'There was a problem validating your tracked template fields, please try again. validator failed:'.json_encode($fieldValidator->errors), "code" => 500)));
						}
					}
					$ti->fields()->save($fields);
					$ti->category->template->active = 1;
					$ti->category->template->save();
				}
				return json_encode(array('success'=>true));
				// return Redirect::to('TrackedItem/manage');
			}
			catch(Exception $e){
				header('HTTP/1.1 500 Internal Server Error');
		        header('Content-Type: application/json');
				die(json_encode(array('message' => "There was a problem trying to create that tracked item.  Please try again:" . json_encode($e->getMessage()), "code" => 500)));
			}
		}
	}

	public function action_read($empID)
	{
		$archived = e(Input::get('archived'));
		$needle = e( Input::get( 'criteria' ) );
		if ( !is_null( $needle ) and strlen( $needle ) > 0 ) {
			$ti = TrackedItem::with(array('category', 'category.template', 'fields', 'fields.templateField'))->where('deleted','=',$archived)->where('itemName','LIKE','%'.$needle.'%')->or_where('id', '=', $needle)->where('employee_id','=',$empID)->get();
		} else {
			$ti = TrackedItem::with(array('category', 'category.template', 'fields', 'fields.templateField'))->where('deleted','=',$archived)->where('employee_id','=',$empID)->get();
		}
		return Response::eloquent($ti);
	}
	
	//function to display the form to manage the tracked items and the archived tracked items
	public function action_manage($empID)
	{	
		//variables to store information for the tracked items
		$e = Employee::find($empID);
		$ti = $e->trackeditems;
		$ai = $e->archiveditems;
		$tc = TrackedCategory::with(array('template', 'template.templateFields'))->where('deleted', '=',0)->get();
		
		//put the variables into the array
		$data = array(
				'employee'=>$e,
				'trackeditems'=>$ti,
				'trackedcategories'=>$tc,
				'archiveditems'=>$ai,
			);
		//make form for tracked items
		$this->layout->content = View::make('trackeditem.manage',$data);	
	}
	
	//function to edit a tracked item
	public function action_edit($id)
	{
		//rules to validate the input
		$rules = array(
			'itemName'		  => 'required|match:/[A-z]*/|max:50|min:1',
			'itemDescription' => 'match:/[A-z]*/|max:200',
			//'itemExpiration'  => 'required|match:/[0-1]',
			// 'url'             => 'required|match:/[A-z+]|*/|max:200',
		);
		
		// get the data from the fields
		$data = array(
			'employee_id'		=> e(Input::get('employeeID')),
			'itemName'			=> e(Input::get('itemName')),
			'itemDescription'	=> e(Input::get('itemDescription')),
			'trackedcategory_id'		=> e(Input::get('itemCategory')),
		);

		//if something is in the itemExpiration field
		if(strlen(Input::get('itemExpiration'))>0){
			$itemExpiration = Input::get('itemExpiration');
		}
		
		$fields = json_decode(Input::get('fields'));
		//validate the input
		$v = Validator::make($data, $rules);
		
		//if the validation fails
		if($v->fails())
		{
			header('HTTP/1.1 500 Internal Server Error');
	        header('Content-Type: application/json');
			die(json_encode(array('message' => "Some fields did not validate.  Change and resubmit", "code" => 500)));
		}

		//the validation succeeds
		else{
			//save the input data in a try/catch
			try{
				
				$ti = TrackedItem::find($id);
				$ti->fill($data)->save();
				if(isset($itemExpiration))
					$ti->itemExpiration = DateTime::createFromFormat("Y-m-d H:i:s",date("Y-m-d H:i:s",strtotime($itemExpiration)));
				$ti->save();
				//if deleteFile is selected
				if(strlen(Input::get('deleteFile'))>0){
					File::delete("public/".$ti->itemurl);
					$ti->itemurl = '';
					$ti->save();
				}
				//if a new file is added
				if(count(Input::file())>0 && strlen(Input::get('newFile'))>0){
					$files = Input::file();
					Input::upload('file', 'public/uploads/files', $files['file']['name']);
					$ti->itemurl = "/uploads/files/".$files['file']['name'];
					$ti->save();
				}
				
				if(count($fields)>0){
					$fieldRules = array(
							'response'		  => 'required|match:/[A-z]*/|max:200|min:1',
							'trackedtemplatefield_id'=> 'required'
							);
					for ($i=0; $i < count($fields); $i++) { 
						$fields[$i] = (array)$fields[$i];
						$fieldValidator = Validator::make($fields[$i], $fieldRules);
						if($fieldValidator->fails()){
							header('HTTP/1.1 500 Internal Server Error');
					        header('Content-Type: application/json');
							die(json_encode(array('message' => 'There was a problem validating your tracked template fields, please try again. validator failed:'.json_encode($fieldValidator->errors), "code" => 500)));
						}
						if (array_key_exists('id', $fields[$i])) {
							TrackedItemField::find($fields[$i]['id'])->fill($fields[$i])->save();
						} else{
							$tif = new TrackedItemField($field);
							$ti->fields()->insert($tif);
						}
					}
				}
				return json_encode(array('success'=>true));
			}
			catch(Exception $e){
				header('HTTP/1.1 500 Internal Server Error');
		        header('Content-Type: application/json');
				die(json_encode(array('message' => "There was an error trying to create that item", "code" => 500)));
			}
		}
	}

	//function to archive a trackedItem. The TrackedItem becomes hidden
	public function action_archive($id)
	{
		if(Auth::user()->can('trackedItemDeletion') )
		{
			$ti = TrackedItem::find($id);
			$ti->deleted = 1;
			$ti->save();
			if(isset($ti->category->activeItems)){
				if(count($ti->category->activeItems) == 0){
					$ti->category->template->active = 0;
					$ti->category->template->save();
				}
			}
			return json_encode(array('success'=>true));
		}
		else
		{
			header('HTTP/1.1 500 Internal Server Error');
	        header('Content-Type: application/json');
			die(json_encode(array('message' => "You don't have permission to archive tracked items", "code" => 500)));
		}	
	}
	//function to unarchive a trackedItem. The trackedItem becomes visible
	public function action_unarchive($id)
	{
		if(Auth::user()->can('trackedItemCreation') )
		{
			$ti = TrackedItem::find($id);
			if(is_object($ti->category)){
				if($ti->category->deleted==1){
					return json_encode(array('success'=>false,'error'=>"This items category has been archived, unarchive category before unarchiving item."));
				}
				$ti->category->template->active = 1;
				$ti->category->template->save();
			}
			$ti->deleted = 0;
			$ti->save();
			return json_encode(array('success'=>true));
		}
		else
		{
			header('HTTP/1.1 500 Internal Server Error');
	        header('Content-Type: application/json');
			die(json_encode(array('message' => "You don't have permission to unarchive tracked items", "code" => 500)));
		}	
	}
	
}