<!-- <div id="manageTabs"> how it used to be, remove for conformity -->
	<ul class="breadcrumb">
		<li><a href="#employees">Main</a></li>
		<?php //if(Auth::user()->can('reportGeneration') || Auth::user()->can('reportTemplate')){ ?>
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

@section('styles')
<style type="text/css">
</style>
@endsection
@section('scripts')
<script type="text/javascript">
	$("#manageTabs").tabs();
</script>
@endsection