<div id="manageTabs">
	<ul>
		<li><a href="#employees">Personnel</a></li>
		<?php //if(Auth::user()->can('reportGeneration') || Auth::user()->can('reportTemplate')){ ?>
		<!-- <li><a href="#reports">Reports</a></li> -->
		<?php //} ?>
	</ul>
	<div id="employees">
		{{$employeeContent}}
	</div>
	<?php //if(Auth::user()->can('reportGeneration') || Auth::user()->can('reportTemplate')){ ?>
	<!-- <div id="reports"> -->
		<?php //echo $reportContent; ?>
	<!-- </div> -->
	<?php //} ?>
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