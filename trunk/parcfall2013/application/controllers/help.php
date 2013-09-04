<?php

class Help_Controller extends Base_Controller 
{
	public $helplayout = 'help.index';
	public function action_index(){
		return Redirect::to( '/help/guide/createClientEmployee' );
	}
	public function action_guide($guide){
		$this->layout->content = View::make( 'help.index' );
		try{
			$this->layout->content->content = View::make( 'help.'.$guide );
		}catch(Exception $e){
			Session::flash( 'errors', 'That guide doesn\'t exist yet' );
			return Redirect::to( 'help/index' );
		}
	}
}