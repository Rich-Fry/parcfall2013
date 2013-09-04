<?php

class Account_Controller extends Base_Controller {    

	public function __construct() {
		$this->filter( 'before', 'csrf' )->only( array( 'login' ) );
		$this->filter( 'before', 'auth' )->only( array( 'logout', 'delete', 'manage', 'verifyForm', 'verify' ) );
		parent::__construct();
	}

	//function to login user
	public function action_login()
	{
		//get information from fields and input the info in an array
		$data = array(
			'username' => Input::get('username'),
			'password' => Input::get('password'),
			'remember' => Input::get('remember'),
		);
		try{
			$ok = Auth::attempt($data);
			// $ok = Auth::attempt(Input::get('username'),Input::get('password'));
			//if $ok is true and authenticates then go to manage account
			if($ok){
				return Redirect::to('account/manage');
			}else{
				Session::flash( 'errors', "Unable to log in, invalid username or password." );
				return Redirect::to('home/index');
			}
			//catch any exceptions
		}catch(Exception $e){
			Session::flash( 'errors', $e->getMessage() . ".  username: " . $data['username']);
			return Redirect::to('home/index');
		}
	}    

	//function to logout user
	public function action_logout()
	{
		Auth::logout();
		return Redirect::to('home/index');
	}    
	
  public function action_updateSVN(){

    $command = 'svn --non-interactive --username adam --password trost123 update L:\Code\dev-newtrackeditems2 --config-dir C:\Windows\Temp'; 

	$response = array();
	$handle = popen("$command 2>&1", 'r');
	$read = '';
	while( $read = fread( $handle, 20096 ) ) 
	{
	    $response[] = $read;
	}
	pclose( $handle );
	flush();

	return '<h2>Response</h2><p>' . implode( '<br />', $response ) . '</p>';
  } 	
public function action_manage()
	{
		$this->layout->content = View::make( 'account.manage' );
	    $manage = $this->layout->content;
	    $manage->employeeContent = View::make( 'employee.manage' );
	    $manage->reportContent = View::make( 'report.manage' );
	}
}