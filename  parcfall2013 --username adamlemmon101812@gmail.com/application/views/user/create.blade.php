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
	input[type='checkbox']{
		margin-top:0;
	}
	input[type='radio']{
		margin-top:0;
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

	$('#accountCreate').validate({
		rules:
		{
			username:{
				required: true,
				email: true,
				minlength: 3
			},
			password:{
				required: true,
				minlength: 6,
			},
			retype_password:{
				required: true,
				equalTo: '#password'
			}
		}
	});

})
</script>
@endsection
<ul class="breadcrumb">
	  <li><a href="/account/manage">Main</a> <span class="divider">/</span></li>
	  <li class="active">Create Account</li>
</ul>
<div class="row-fluid">
	<form id="userCreate" action="/account/create" method="POST">
		<div style="margin-left:0" class="control-group span12">
	        <label class="control-label">Username:</label>
	        <div class="controls">
	            <input type="text" name="username" id="username" placeholder="username"/>
	        </div>
	    </div>
	    <div style="margin-left:0" class="control-group span12">
	        <label class="control-label">Password:</label>
	        <div class="controls">
	            <input type="password" name="password" id='password' placeholder="password"/>
	        </div>
	    </div>
	    <div style="margin-left:0" class="control-group span12">
	        <label class="control-label">Repeat Password:</label>
	        <div class="controls">
	            <input type="password" name="retype_password" id="retype_password" placeholder="password"/>
	        </div>
	    </div>
	    {{Form::token()}}
	    <button onClick="$('userCreate').submit()">Submit</button>
	    <button onclick="window.location='/account/main/">Cancel</button>
	</form>
</div>
