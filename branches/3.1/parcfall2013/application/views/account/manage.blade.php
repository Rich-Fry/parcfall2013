<!-- <div id="manageTabs"> how it used to be, remove for conformity -->
	<ul class="breadcrumb">
		<li class="active">Main</li>
		<?php //if(Auth::user()->can('reportGeneration') || Auth::user()->can('reportTemplateCreation')){ ?>
		<!-- <li><a href="#reports">Reports</a></li> -->
		<?php //} ?>
	</ul>
	<!-- where employee content div used to be -->
	<?php //if(Auth::user()->can('reportGeneration') || Auth::user()->can('reportTemplate')){ ?>
	<!-- <div id="reports"> -->
		<?php //echo $reportContent; ?>
	<!-- </div> -->
	<?php //} ?>
<!-- </div>  how it used to be, remove for conformity -->

<!-- New spot for employee content div -->
<div id="employees">
	{{$employeeContent}}
</div>
<!-- Old Styles & Scripts
@section('styles')
<style type="text/css">
</style>
@endsection
@section('scripts')
<script type="text/javascript">
	$("#manageTabs").tabs();
</script>
@endsection
-->
@section('styles')
	<link rel="stylesheet" href="/styles/css/selectList.css">
	<link rel="stylesheet" href="/styles/css/ui.css">
<style>
.column1{
	width: 48%;
    float:left;
    border-right:solid 1px;
    padding: 0 4px;
    white-space: nowrap;
}
.column2{
    float:left;
    padding: 0 4px;
    white-space: nowrap;
}

.modalHeader{
	background-color:#00A305;
	font-size:medium;
	color:white;
}
.ui-datepicker-trigger{
	margin-top:-10px;
}
.control-label{
	font-size:medium;
}
.controls{
	margin-left:2%;
}
.listColumn{
	background-color:#00A305;
	color:white;
	font-size:medium;
}
.searchButton{
	margin-top:-8px;
}
#buttons button{
	margin-left:0;
}
input[type='radio']{
		margin-top:-2px;
	}
</style>
@endsection