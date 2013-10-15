<?php

class Report_Controller extends Base_Controller {

    public function __construct() {
        $this->filter( 'before', 'auth' );
        parent::__construct();
    }

	public function action_index()
    {

    }

	public function action_create()
    {
        $rules = array(
            'reportFieldID'  => 'required|match:/[0-9+]*/',
            ///'reportID'       => 'required|match:/[0-9+]*/',
            'fieldName'      => 'required|match:/[A-z]*/|max:10|min:1',
            //'formQuestionid' => 'required|match:/[0-9]*/',
        );
        $data = array(
            'reportFieldID'  => e(Input::get('reportFieldID')),
            //'reportID'       => e(Input::get('reportID')),
            'fieldName'      => e(Input::get('fieldName')),
            //'formQuestionid' => e(Input::get('formQuestionid')),
        );
        $f = Input::get('formquestion');
       // Session::flash('errors', 'Programs'.json_encode($data));
        //    return Redirect::to('report/createForm');
        $v = Validator::make($data, $rules);

        if($v->fails())
        {
            Session::flash('errors', 'There was a problem creating your employee, please try again. Errors:'.json_encode($v->errors));
            return Redirect::to('report/createForm');
        }

        else{
            try{

                $e = Report::create($data);
                foreach ($f as $formquestion) {
                    $rtf = new ReportTemplateField;
                    $rtf->reportID = $e->id;
                    $rtf->formQuestionid = $formquestion->id;
                    $rtf->save();
                    // $rff = new ReportFieldFilter;
                    // $rff->filterCriteria = $formquestion->filter->criteria;
                    // $rff->andOrFlag = $formquestion->filter->andOrFlag;
                    // $rff->reportFieldID = $rtf->id;
                    // $rff->save();
                }
                return Redirect::to('report/edit/'.$e->id);
            }
            catch(Exception $e){
                Session::flash('errors', 'There was a problem creating your employee, please try again. Errors:'.json_encode($v->errors));
                return Redirect::to('report/createForm');
            }
        }
    }

	public function action_update()
    {
        $rID = Input::get('reportID');
        $items= Input::get('items');
        $r = ReportTemplate::find($rID);
        $r->questions()->delete();
        for ($i=0; $i < count($items); $i++) {
            $r->questions()->attach($items[$i]);
        }
        // $r->questions($items);
        return json_encode("{success: 'true'}");
    }

	public function action_delete($id)
    {
		if(Auth::user()->is('admin') OR Auth::user()->is('Super Admin') )
		{

			$e = ReportTemplate::find($id);
			$e->deleted = 1;
			$e->save();

			$rf = $e->items;
			for($i=0; $i < count($rf); $i++)
			{
				$rf[$i]->deleted = 1;
				$rf[$i]->filter->deleted = 1;
				$rf[$i]->filter->save();
				$rf[$i]->save();

			}

		}
		else
		{
			Session::flash('errors', "You don't have permission to delete.");
			return Redirect::to('trackeditem/manage');
		}
    }

	public function action_generate($id)
    {
        $r = ReportTemplate::with('report')->find($id);
        $data = array(
            'report' => $report,
            'template'=>$r
        );
        $this->layout->content = View::make( 'report.generate', $data);
    }
    public function action_edit($id)
    {
        if ( Auth::is( 'reportTemplateCreator' ) or Auth::is( 'admin' ) or Auth::is( 'Super Admin' ) ) {
            $r=ReportTemplate::find($id);
            $p=Program::all();
            $data = array(
                'report'=>$r,
                'programs'=>$p,
            );
            $this->layout->content = View::make( 'report.edit', $data );
        }else {
            Session::flash( 'errors', 'You don\'t have permission to edit report templates' );
            return Redirect::to( 'account/manage' );
        }
    }
    public function action_find()
    {
        $criteria = e( Input::get( 'criteria' ) );
        if ( !is_null( $criteria ) and strlen( $criteria ) > 0 ) {
            $needle = e( $criteria );
            $u = ReportTemplate::where( function ( $query ) use ($needle){
                    $query->where( 'reportName', 'LIKE', "%" . $needle . "%" );
                    $query->or_where( 'ID', '=', $needle );
                } )->get();
        } else {
            $u = ReportTemplate::all();
        }
        return Response::eloquent($u);
    }
	public function action_manage()
	{
		if(Auth::user()->can('reportGeneration') || Auth::user()->can('reportTemplate')){
			$u = Verify\Models\User::where('disabled', '=', 0)->get();
			$du = Verify\Models\User::where('disabled', '=', 1)->get();
			$r = Verify\Models\Role::where('deleted', '=', 0)->get();
			$data = array(
				'users' => $u,
				'disabledusers' => $du, 
				'roles' => $r
				);
			$this->layout->content = View::make('Report.manage',$data);	
		}else{
			Session::flash('errors', 'You don\'t have permission to create or edit Users');
			return Redirect::to('account/manage');
		}
	}

}