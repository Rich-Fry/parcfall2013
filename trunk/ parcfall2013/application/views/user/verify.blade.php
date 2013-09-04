@section('styles')
<style type="text/css">
	body{
		font:"Trebuchet MS",sans-serif;
		margin:0;
		padding:0;
		border:0;
	}
	#unverifiedSelectList{
		margin-left: 0px;
	}
	.listColumns{
		background-color:#00A305;
		border:none;
		color:white;
		width:99.9%;
	}
	.listColumn{
		background-color:transparent;
		border:none;
		font-size:medium;
	}
	.modalHeader{
		background-color:#00A305;
		color:white;
		font-size:medium;
	}
	input[type='radio']{
		margin-top:0;
	}
</style>
	<link rel="stylesheet" href="/styles/css/selectList.css">
	<link rel="stylesheet" href="/styles/css/ui.css">
<style>
.column1{
	width: 100%;
}
</style>
@endsection
<ul class="breadcrumb">
	  <li><a href="/account/manage">Main</a> <span class="divider">/</span></li>
	  <li class="active">Verify Users</li>
</ul>
<div style="row-fluid">
	<div id="unverifiedSelectList" class="span8">
		<div class="listColumns">
			<div class="listColumn column1" >Name</div>
		</div>
		<div class="selectList" id="unverifiedSelectListContent">
		</div>
	</div>
	<div class="span2">
	<div id="buttons" class="row-fluid">
		<input type="hidden" name="unverifiedID" value="" id="unverifiedID" />
		<button id="editEmployeeButton" class="span12" disabled="disabled" onclick="if(!buttonDisabled(this))verify()"><i class="icon-edit icon4x"></i>Edit</button>
	</div>
	</div>
</div>
<div class="modalDisplay" id="verifyUserDisplay">
	<div class="modalHeader">Verify and Permissions</div>
	<div class="modalContent">

		 <div id="verify">
			 <div class="control-group span12">
		        <label class="control-label">Verify this user:</label>
		        <div class="controls">
		            <input type="radio" value="1" name="verify" onclick="$('#roles').show();"/><span>Yes (allow this user to login)</span><br/>
		 			<input type="radio" value="0" name="verify"/><span>No (delete this user)</span>
		        </div>
		    </div>
		 	
		 </div>
		 <div id="roles" style="display:none;">
		  	<div class="control-group span12">
		        <label class="control-label">The role of this user:</label>
		        <div class="controls">
		            @foreach($roles as $var)
				 	    <input type="radio" value="{{ $var->id }}" name="role"/><span>{{ $var->name }}</span><br/>
				 	@endforeach
		        </div>
		    </div>
		 </div>
		 <button id="verifySave" onclick="verifySave()"><i class="icon-folder-close icon4x"></i>Save</button>
		 <button id="verifyCancel" onclick="$.unblockUI();"><i class="icon-remove icon4x"></i>Cancel</button>

	</div>
</div>
@section('scripts')
<script type="text/javascript" src="/js/SelectList.js"></script>
<script type="text/javascript" src="/js/jQuery/jquery.blockUI.js"></script>
<script type="text/javascript">
var unverifiedSelectList = new SelectList('unverifiedSelectList');

unverifiedSelectList.list = {{$unverified}};
console.log(unverifiedSelectList.list);
unverifiedSelectList.updateButtons = function(){
	var disabled = (unverifiedSelectList.selectedItem == 0);
	if(disabled){
		$( "#editEmployeeButton" ).button('disable');
	}else{
		$( "#editEmployeeButton" ).button('enable');
	}
}
var theHTML = '';
for (var row=0; row < unverifiedSelectList.list.length; row++){
			theHTML += '<div id="unverified_' + row + '" class="selectItem' + ((row) % 2 == 0 ? 'Even' : 'Odd') + '" onclick="unverifiedSelectList.clickItem(this)" ondblclick="unverifiedSelectList.clickItem(this);if(unverifiedSelectList.selectedItem.length > 0)verify();"  data-userID="'+unverifiedSelectList.list[row].id+'">';
			theHTML += '<div class="column1">'+ unverifiedSelectList.list[row].username + '</div>';       
			theHTML +=  '</div>';
		}
		$("#unverifiedSelectListContent").html(theHTML);
function verify () {
	$.blockUI({
        message: $('#verifyUserDisplay'),
        css: {
            width: '400'
            ,height: '300'
            ,top: ($(window).height() / 2) - (300 / 2)
            ,left: ($(window).width() / 2) - (400 / 2)
        },
        onBlock: function(){

        },
        onUnblock: function(){
            
        }
    });
	
	
}
function verifySave () {
	var d = {};
	var ver = $("#verify input[name='verify']:checked").val();
	var rol = $("#role input[name='role']:checked").val()
	if(ver.length>0)
		var del = (ver===0?1:0);
	if(typeof ver !== 'undefined')
		d.verify = ver;
	if(typeof rol !== 'undefined')
		d.role = rol;
	if(typeof del !== 'undefined' && del === 1){
		jQuery.ajax({
			  url: '/account/delete/'+unverifiedSelectList.list[unverifiedSelectList.selectedItem.split('_')[1]].id,
			  type: 'POST',
			  dataType: 'json',
			  data:d,
			  success: function(data, textStatus, xhr) {
			    console.log('deleted', data);
			    $.unblockUI();
			  },
			  error: function(xhr, textStatus, errorThrown) {
			    //called when there is an error
			  }
			});	
	} else {
		jQuery.ajax({
			  url: '/account/verify/'+unverifiedSelectList.list[unverifiedSelectList.selectedItem.split('_')[1]].id,
			  type: 'POST',
			  dataType: 'json',
			  data:d,
			  success: function(data, textStatus, xhr) {
			    console.log('verified', data);
			    $.unblockUI();
			  },
			  error: function(xhr, textStatus, errorThrown) {
			    //called when there is an error
			  }
			});	
	}
	
}
$(function(){
	$('button').button();
})
</script>
@endsection