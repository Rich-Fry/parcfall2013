@section('styles')
<style type="text/css">

	.form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin-left: auto;
        margin-right: auto;
        background: #cdd1ce; /* Old browsers */
		background: -moz-linear-gradient(top, #cdd1ce 0%, #dce3c4 41%, #fefefd 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#cdd1ce), color-stop(41%,#dce3c4), color-stop(100%,#fefefd)); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, #cdd1ce 0%,#dce3c4 41%,#fefefd 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top, #cdd1ce 0%,#dce3c4 41%,#fefefd 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top, #cdd1ce 0%,#dce3c4 41%,#fefefd 100%); /* IE10+ */
		background: linear-gradient(to bottom, #cdd1ce 0%,#dce3c4 41%,#fefefd 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cdd1ce', endColorstr='#fefefd',GradientType=0 ); /* IE6-9 */
        border-top: 25px solid #00A305; 
		border-radius:20px;
		-moz-border-radius:20px; /* Old Firefox */
		box-shadow: 7px 7px 5px #2B452D;
		position: relative;;
    }

    .form-signin .form-signin-heading, .form-signin .checkbox {
        margin-bottom: 10px;
    }

    .form-signin input[type="text"], .form-signin input[type="password"] {
        font-size: 16px;
        width: 80%;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
    }
    .control-label{
		font-size:medium;
		font-weight: bold;
	}
	.controls{
		margin-left:2%;
	}
	input[type='checkbox']{
		margin-top:0;
	}
</style>
@endsection
@section('scripts')
<script type="text/javascript">
	$(function(){
		$("button").button();
	});
</script>
@endsection
<div class="hero-unit">
	<form action="/account/login" class="form-inline" >
		<div class="form-signin">
			<div class="control-group">
			    <label class="control-label" for="username">Email</label>
			    <div class="controls">
			      <input type="text" id="username" name="username" placeholder="Email">
			    </div>
			</div>
			<div class="control-group">
				<label class="control-label" for="password">Password</label>
			    <div class="controls">
			      <input type="password" id="password" name="password" placeholder="Password">
			    </div>
			</div>
			<div class="control-group">
			    <div class="controls">
			      <label class="checkbox">
			        <input type="checkbox" id='remember' name='remember'> Remember me
			      </label>
			      <button type="submit" class="btn" style="float:right;"><i class="icon-key icon4x"></i>Sign in</button>
			    </div>
			</div>
		</div>
		  <?php 
		  echo Form::token();
		  ?>
	</form>
</div>	