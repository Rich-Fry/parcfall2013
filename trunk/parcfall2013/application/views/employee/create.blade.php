@section('styles')
<style type="text/css">
	body{
		font:"Trebuchet MS",sans-serif;
		margin:0;
		padding:0;
		border:0;
	}
	.container{
		max-width:1000px;
		padding:19px 29px 29px;
		margin:0 auto 10px;
		margin-top:30px;
		background:#cdd1ce;
		background: -moz-linear-gradient(top, #cdd1ce 0%, #dce3c4 41%, #fefefd 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#cdd1ce), color-stop(41%,#dce3c4), color-stop(100%,#fefefd)); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, #cdd1ce 0%,#dce3c4 41%,#fefefd 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top, #cdd1ce 0%,#dce3c4 41%,#fefefd 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top, #cdd1ce 0%,#dce3c4 41%,#fefefd 100%); /* IE10+ */
		background: linear-gradient(to bottom, #cdd1ce 0%,#dce3c4 41%,#fefefd 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cdd1ce', endColorstr='#fefefd',GradientType=0 ); /* IE6-9 */
		border-top:25px solid #00A305;
		border-radius:15px;
		-moz-border-radius:20px;/*Old Firefox*/
		box-shadow:7px 7px 5px #2B452D;
		position:relative;
	}
	.controls{
		font-size:14px;
		padding-left:1.5%;
	}
	.control-label{
		font-size:18px;
		font-weight: bold;
	}
	#employeeCreate label.error {
		color:red;
		display:none;
	}

	input[type="text"], input[type="password"] {
        font-size: 16px;
        width: 300px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
    }
</style>
@endsection
@section('scripts')
<script type="text/javascript">
$(function(){
	$('button').button();
           
       $("#employeeCreate").validate({
       		rules:
       		{
       			firstname:{
       				required: true
       			},
       			lastname:{
       				required: true
       			},

       			program:{
       				required: true
       			}
       		}
       	});
})
</script>
@endsection
<ul class="breadcrumb">
	  <li><a href="/account/manage">Main</a> <span class="divider">/</span></li>
	  <li class="active">Create Employee/Client</li>
</ul>
<div class="row-fluid">
	<form id="employeeCreate" action="/employee/create" method="POST">
		<div style="margin-left:0" class="control-group span12">
	        <label class="control-label">First Name:</label>
	        <div class="controls">
	            <input type="text" name="firstname" id="firstname" placeholder="First Name"/>
	        </div>
	    </div>
	    <div style="margin-left:0" class="control-group span12">
	        <label class="control-label">Last Name:</label>
	        <div class="controls">
	            <input type="text" name="lastname" placeholder="Last Name"/>
	        </div>
	    </div>
	    <div style="margin-left:0" class="control-group span12">
	        <label class="control-label">Client or Employee</label>
	        <div class="controls">
	            <input type="radio" value="1" name="client" checked="checked"/><span>Client</span><br/>
	 			<input type="radio" value="0" name="client"/><span>Employee</span>
	        </div>
	    </div>
	    <div style="margin-left:0" class="control-group span12">
	        <label class="control-label">Programs</label>
	        <label for="program" class="error">Please select at least one program.</label>
	        <div class="controls">
	        <?php $i = 0;?>
	        	@foreach($programs as $program)
	        	
	        	    <input type="checkbox" value="{{$program->id}}" name="program[]"/><span>{{$program->programname}}</span><br/>
	        	    <?php $i +=1;?>
	        	@endforeach
	        </div>
	    </div>
	    <button onclick="$('employeeCreate').submit()"><i class="icon-plus-sign icon4x"></i>Submit</button>
	    <button onclick="window.location='/account/manage/';return false"><i class="icon-remove icon4x"></i>Cancel</button>
	</form>
</div>
