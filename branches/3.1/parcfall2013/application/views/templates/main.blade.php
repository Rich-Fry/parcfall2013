<!doctype html>
<html>
<head>
	<title>SPEED 3.1<?php if(defined('$title'))echo " - $title"; ?></title>
</head>
<link rel="stylesheet" href="/styles/css/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="/styles/css/bootstrap/css/bootstrap-responsive.min.css">
<link rel="stylesheet" href="/styles/fonts/FontAwesome/css/font-awesome.min.css">
<link rel="stylesheet" href="/styles/css/south-street/jquery-ui.css">
<link rel="stylesheet" href="/styles/css/speedStyles.css">
<style type="text/css">
	.container{
		/*max-width:1000px;*/
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
	.error{
		color: red;
	}
</style>
@yield('styles')
<body>
	<div class="pageHead">
	<a href="{{Auth::check()?'/account/manage':'/home/index'}}">
		<img src="/img/PARCLogo.png" id="parcLogo"/> 
		<img src="/img/speedLogo.png" id="speedLogo"/></a>
		<img src="/img/edge.png" id="edge"/> 
	

	
		<div class="row-fluid">
		    @if (Session::has( 'info' ))
		        <span class="info"><i class="icon-info-sign"></i>{{Session::get('info')}}</span>
		    @endif
		    <div id="userSettings" style="float:right">
			    <ul class="breadcrumb" style=" margin-bottom:4px;">
			    @if (Auth::check())
			    	<li>Greetings <a href="/user/editForm/{{Auth::user()->id}}" title="Edit your account"><i class='icon-user'></i>{{Auth::user()->username}}</a></li>
					<li> <span class="divider"><i class="icon-double-angle-right"></i></span> <a href="/account/logout/">Logout</a></li>
					<li> <span class="divider"><i class="icon-double-angle-right"></i></span> <a href="/help/index">Help</a></li>
			   @else
			    	<li><a href="/user/createForm"><i class="icon-user"></i>Create Account</a></li> 
			    @endif
			    </ul>
			    @if(Auth::check())
			    <?php if(Auth::user()->can('userCreation') || Auth::user()->can('programCreation') || Auth::user()->can('categoryCreation') || Auth::user()->can('reportGeneration')){ ?>
			    <ul class="breadcrumb" >
					<?php if(Auth::user()->can('userCreation') ){ ?>
		    			<li> {{HTML::link("user/manage", "Users");}}</li>
					<?php } ?>
					<?php if(Auth::user()->can('programCreation') ){ ?>
		    			<li> <span class="divider"><i class="icon-double-angle-right"></i></span> {{HTML::link("program/manage", "Programs");}}</li>
					<?php } ?>
					<?php if(Auth::user()->can('categoryCreation') ){ ?>
		    			<li> <span class="divider"><i class="icon-double-angle-right"></i></span> {{HTML::link("trackedcategory/manage", "Categories");}}</li>
					<?php } ?>
					<?php if(Auth::user()->can('reportGeneration') || Auth::user()->can('reportTemplate') ){ ?>
		    			<li> <span class="divider"><i class="icon-double-angle-right"></i></span> {{HTML::link("report/manage", "Reports");}}</li>
					<?php } ?>
				</ul>
				<?php } ?>
				@endif
		    </div>
		</div>
		</div>
	<div class="container">
		{{$content}}
	</div>
	<script type="text/javascript" src="/js/jQuery/jquery.min.js"></script>

	<script type="text/javascript" src="/js/jQuery/jquery-ui.min.js"></script>
	<script type="text/javascript" src="/js/jQuery/jqueryui.combobox.js"></script>
	<script type="text/javascript" src="/js/jQuery/jquery-validate.min.js"></script>
	<script type="text/javascript" src="/js/jQuery/jquery.sortSelectList.js"></script>
	<script type="text/javascript" src="/js/lodash.min.js"></script>

	@yield('scripts')
	@if (Session::has( 'errors' ))
        <div class="error" id="errorModal">{{Session::get('errors')}}</div>
    	<script type="text/javascript">
    	$(function () {
    		$("#errorModal").dialog({
    			height:300,
    			modal:true, 
    			buttons:{
    				Ok: function(){
    					$(this).dialog('close')
    				}
    			}
    		});
    	})
    		
    	</script>
	@endif
</body>
</html>