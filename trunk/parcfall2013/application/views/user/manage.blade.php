<ul class="breadcrumb">
	  <li><a href="/account/manage">Main</a> <span class="divider">/</span></li>
	  <li class="active">Users</li>
</ul>

<div style="row-fluid">
	<div class="tabs span8">
		<ul>
			<li><a href="#active" onclick="tabFlag=0;userSelectList.updateButtons();">Active Users</a></li>
			<li><a href="#disabled" onclick="tabFlag=1;disabledUserSelectList.updateButtons();">Disabled Users</a></li>
		</ul>
		<div id="active">
			<div id="userSelectList" >
				<div class="searchFor">Enter the user name or id:</div>
				<div class="searchBox">
					<input type="text" name="userSelectList_criteria" id="userSelectList_criteria" maxlength="100" style="width:80%" >
					<button id="searchActiveButton" class="searchButton" onclick="updateSelectList(0);"><i class="icon-search icon4x"></i>Go</button>
				</div>
				<div class="listColumns">
					<div class="listColumn column1" >User Name</div>
					<div class="listColumn column2" >Date Modified</div>
				</div>
				<div class="selectList" id="userSelectListContent" style="margin-left:0;">
				</div>
			</div>
		</div>
		<div id="disabled">
			<div id="disabledUserSelectList" >
				<div class="searchFor">Enter the user name or id:</div>
				<div class="searchBox">
					<input type="text" name="disabledUserSelectList_criteria" id="disabledUserSelectList_criteria" maxlength="100" style="width:80%" >
					<button id="searchDisabledButton" class="searchButton" onclick="updateSelectList(1);"><i class="icon-search icon4x"></i>Go</button>
				</div>
				<div class="listColumns">
					<div class="listColumn column1" >User Name</div>
					<div class="listColumn column2" >Date Modified</div>
				</div>
				<div class="selectList" id="disabledUserSelectListContent" style="margin-left:0;">
				</div>
			</div>
		</div>
	</div>
	<div class="span3">
	<div id="buttons" class="row-fluid">
		@if(Auth::user()->can('userCreation'))
			<button id="createUserButton" class="span12" onclick="view('create')"><i class="icon-plus-sign icon4x"></i>Create</button>
			<button id="editUserButton" class="span12" disabled="disabled" onclick="if(!buttonDisabled(this))view('edit')"><i class="icon-edit icon4x"></i>Edit</button>
		@endif
		<button id="viewUserButton" class="span12" disabled="disabled" onclick="if(!buttonDisabled(this))view('view')"><i class="icon-eye-open icon4x"></i>View</button>
		@if(Auth::user()->can('userDeletion'))	
			<button id="archiveUserButton" class="span12" disabled="disabled" ><i class="icon-trash icon4x"></i>Archive</button>
		@endif
		@if(Auth::user()->can('roleCreation'))
			<button id="manageRolesButton" class="span12" onclick="window.location = '/role/manage/'"><i class="icon-trash icon4x"></i>Manage System Roles</button>
		@endif
	</div>
	</div>
</div>
<div id="archiveDialog" style="display:none;">
	<p><i class="icon-warning-sign"></i>Are you sure you'd like to disable this user?</p>
</div>
<div id="unarchiveDialog" style="display:none;">
	<p><i class="icon-warning-sign"></i>Are you sure you'd like to enable this user?</p>
</div>
<script type="text/template" id="userTemplate">
	<div class="modalDisplay" id="userDisplay" Title="Edit User Account">
		<form class="modalContent row-fluid" id="userForm" style="padding-left:0;">
			<%if(id=='create'){%>
				<div id="createInfo">
					<div class="control-group">
				        <label class="control-label">Username/email:</label>
				        <div class="controls">
				        	<input type="email" name="username" value="" id="username" placeholder="johndoe@example.com">
				        </div>
			    	</div>
			    	<div class="control-group">
				        <label class="control-label">Password:</label>
				        <div class="controls">
				        	<input type="password" name="password" value="" id="password" placeholder="password">
				        </div>
			    	</div>
			    	<div class="control-group">
				        <label class="control-label">Retype Password:</label>
				        <div class="controls">
				        	<input type="password" name="retype_password" value="" id="retype_password" placeholder="password">
				        </div>
			    	</div>
				</div>
			<%}else{%>
				<div class="control-group">
			        <label class="control-label">Username/email:</label>
			        <div class="controls">
			        	<input type="email" name="username" value="<%= username %>" placeholder="johndoe@example.com" disabled='disabled'>
			        </div>
		    	</div>
			<% } %>
			 <div id="verify">
				 <div class="control-group">
			        <label class="control-label">Verify this user:</label>
			        <div class="controls">
			            <input type="radio" value="1" name="verify" onclick="$('#roles').show()" <%= (typeof viewing !=="undefined" && viewing === true?'disabled="disabled"':'') %> <%=(typeof verified !== 'undefined' && verified?checked='checked':'')%>/><span>Yes (allow this user to login)</span><br/>
			 			<input type="radio" value="0" name="verify" onclick="$('#roles').hide()" <%= (typeof viewing !=="undefined" && viewing === true?'disabled="disabled"':'') %> <%=(typeof verified !== 'undefined' && !verified?checked='checked':'')%> /><span>No (don't allow this user to login)</span>
			        </div>
			    </div>
			 	
			 </div>
			 <div id="roles">
			  	<div class="control-group">
			        <label class="control-label">The role of this user:</label>
			        <div class="controls">
					 	<select class="roleCombobox" name="role" <%= (typeof viewing !=="undefined" && viewing === true?'disabled="disabled"':'') %>>
					        <option value="">Select one...</option>
				            @foreach($roles as $var)
						 	    <option value="{{ $var->id }}" <%= (typeof role_id !=="undefined" && role_id==={{$var->id}}? 'selected':'') %>  >{{ $var->name }}</option>
						 	@endforeach
					 	</select>
			        </div>
			    </div>
			 </div>
		</form>
	</div>
</script>
@section('scripts')
<script type="text/javascript" src="/js/SelectList.js"></script>
<script type="text/javascript" src="/js/jQuery/jquery.blockUI.js"></script>
<script type="text/javascript">
$(function(){
	$('button').button();
	userSelectList.updateButtons();
	$(".tabs").tabs();
	printSelectList(0);
	printSelectList(1);

});
jQuery.validator.addMethod("validPass", function(value, element) {
         var re = new RegExp("^(?=.*\\d)(?=.*[a-z])(?=.*[A-Z]).{6,32}$");
         return this.optional(element) || re.test(value);
     }, "Password must contain at least 6 characters. One uppercase, one lowercase and one number.");


var tabFlag = 0;
var userSelectList = new SelectList('userSelectList');
var disabledUserSelectList = new SelectList('disabledUserSelectList');
var tmpl = _.template($('#userTemplate').html());
userSelectList.list = {{Response::eloquent($users)}};
disabledUserSelectList.list = {{Response::eloquent($disabledusers)}};
console.log(userSelectList.list);
var buttons = function(){
	var list = (tabFlag ===0?userSelectList:disabledUserSelectList);
	var disabled = (list.selectedItem == 0);
	$delBtn = $("#archiveUserButton");
	if(tabFlag === 1){
		$delBtn.html('<span class="ui-button-text"><i class="icon-trash icon4x"></i>Unarchive</span>');
		$delBtn.off('click',archiveItem);
		$delBtn.on('click',unarchiveItem);
	}else{
		$delBtn.html('<span class="ui-button-text"><i class="icon-trash icon4x"></i>Archive</span>');
		$delBtn.off('click',unarchiveItem);
		$delBtn.on('click',archiveItem);
	}
	if(disabled){
		$("#editUserButton").button("disable");
		$("#viewUserButton").button("disable");
		$("#archiveUserButton").button("disable");
	}else{
		$("#editUserButton").button("enable");
		$("#viewUserButton").button("enable");
		$("#archiveUserButton").button("enable");
	}
}
userSelectList.updateButtons = buttons;
disabledUserSelectList.updateButtons = buttons;
function updateSelectList (flag) {
	var content = (flag ===0?"userSelectListContent":"disabledUserSelectListContent");
	$("#"+content).block({
			message:'<div style="font-family:Arial;font-weight:bold;">Loading . . . <img src="/img/loading.gif" style="vertical-align:middle;"></div>',
			css: {
				border:                     'none',
				padding:                    '15px',
				backgroundColor:            '#000',
				'-webkit-border-radius':    '10px',
				'-moz-border-radius':       '10px',
				opacity:                    .5,
				color:                      '#fff',
				onBlock: function () {
					var d={
						archived: flag
					}
					var c = $("#"+(flag===0?'userSelectList_criteria':'disabledUserSelectList_criteria')).val();
					if(c.length>0)
						d['criteria'] = c;
					jQuery.ajax({
						  url: '/user/read/'+flag,
						  type: 'POST',
						  data:d,
						  dataType: 'json',
					 	  success: function(data, textStatus, xhr) {
					 	  	if(flag === 0)
					 	  		userSelectList.list = data;
					 	  	else
					 	  		disabledUserSelectList.list = data;
					 	  	$("#"+content).unblock();
					 	  	printSelectList(flag);
					  	  }
					});
				}
			}
		});

	
}
function printSelectList (flag) {
	var theHTML = '';
	var content = (flag ===0?"userSelectListContent":"disabledUserSelectListContent");
	var list = (flag ===0?userSelectList:disabledUserSelectList);
	for (var row=0; row < list.list.length; row++){
			theHTML += '<div id="'+(flag ===0?'userSelectList':'disabledUserSelectList')+'user_' + row + '" class="selectItem' + ((row) % 2 == 0 ? 'Even' : 'Odd') + '" onclick="'+(flag ===0?"userSelectList":"disabledUserSelectList")+'.clickItem(this)" ondblclick="'+(flag ===0?"userSelectList":"disabledUserSelectList")+'.clickItem(this);if('+(flag ===0?"userSelectList":"disabledUserSelectList")+'.selectedItem.length > 0)view(\'view\');"  data-itemID="'+list.list[row].id+'">';
			theHTML += '<div class="column1">'+ list.list[row].username + '</div>';
			theHTML += '<div class="column2">'+ list.list[row].updated_at + '</div>';
			theHTML +=  '</div>';
		}
		$("#"+content).html(theHTML);
}
function view (type) {
	var msg;
	var b;
	var validator;
	var list = (tabFlag ===0?userSelectList:disabledUserSelectList);
	if(type=="edit"){
		if (list.selectedItem.length > 0){
        	var row = list.selectedItem.split('_')[1];
        	list.list[row].viewing= false;
			msg = tmpl(list.list[row]);
			b = {
				Save: function(){
					if(validator.form()){
						itemSave(list.list[row].id)
					}
					$(this).dialog('close');
				},
				Close: function(){
					$(this).dialog('close');
				}
			}
		}
	}else if(type=="create"){
		msg = tmpl({id: 'create'});
		b = {
			Create: function(){
				if(validator.form()){
					itemSave('create');
				}
				$(this).dialog('close');
			},
			Cancel: function(){
				$(this).dialog('close');
			}
		}
	}else if(type=="view"){
		if (list.selectedItem.length > 0){
        	var row = list.selectedItem.split('_')[1];
        	list.list[row].viewing= true;
			msg = tmpl(list.list[row]);
			b = {
				Close: function(){
					$(this).dialog('close');;
				}
			}
		}
	}
	
	$(msg).dialog({
		resizable: true,
		height:380,
		width: 300,
		modal: true,
		buttons: b,
		open: function () {
			var rules;
			var messages;
			if(type === 'create'){
				var btnCreate = $('.ui-dialog-buttonpane').find( 'button:contains("Create")' );
				btnCreate.prepend('<i class="icon-plus-sign icon4x" style="float:left;padding-top:8px;padding-left:10px;"></i>');
				btnCreate.width(btnCreate.width() + 25);
				var btnCancel = $('.ui-dialog-buttonpane').find( 'button:contains("Cancel")' );
				btnCancel.prepend('<i class="icon-remove icon4x" style="float:left;padding-top:8px;padding-left:10px;"></i>');
				btnCancel.width(btnCancel.width() + 25);
				rules = {
					username:{
						required: true,
						email: true
					},
					password:{
						required: true,
						validPass: true
					},
					retype_password:{
						required: true,
						equalTo: '#password'
					}
				};
				messages = {
					username:{
						required: "Username is required",
						email: "Username must be a valid email address"
					},
					password:{
						required: "Password is required"
					},
					repeat_password:{
						equalTo: "Passwords do not match"
					}
				}
			}else if(type === 'edit'){
				var btnSave = $('.ui-dialog-buttonpane').find( 'button:contains("Save")' );
				btnSave.prepend('<i class="icon-folder-close icon4x" style="float:left;padding-top:8px;padding-left:10px;"></i>');
				btnSave.width(btnSave.width() + 25);
				var btnClose = $('.ui-dialog-buttonpane').find( 'button:contains("Close")' );
				btnClose.prepend('<i class="icon-remove icon4x" style="float:left;padding-top:8px;padding-left:10px;"></i>');
				btnClose.width(btnClose.width() + 25);
				rules = {
						role:{
							required: true
						}
					};
				messages = {
						role: {
							required: "Please select a role for this user"
						}
					};
			}else if(type === 'view'){
				var btnClose = $('.ui-dialog-buttonpane').find( 'button:contains("Close")' );
				btnClose.prepend('<i class="icon-remove icon4x" style="float:left;padding-top:8px;padding-left:10px;"></i>');
				btnClose.width(btnClose.width() + 25);
			}
			if(type!=='view'){
		//		$(this).find('.roleCombobox').combobox();
        		validator = $("#userForm").validate({
					rules:rules,

					messages:messages
				});
        	}
		},
		close: function(){
			$(this).remove();
		}
	})	
}
function itemSave (criteria) {
	
	if(criteria === 'create'){
		var d = {
		  	username: $('#username').val(),
		  	password: $('#password').val(),
		  	verified: $("#verify input[name='verify']:checked").val(),
		  	role: $('.roleCombobox').val()
		  };
		$.ajax({
		  url: '/user/create',
		  type: 'POST',
		  dataType: 'json',
		  data: d,
		  success: function(data, textStatus, xhr) {
		    // alert(data);
		    console.log(data);
		    $.unblockUI();
		    updateSelectList(0);
		  }
		});
	}else{
		var d = {
		  	verified: $("#verify input[name='verify']:checked").val(),
		  	role: $('.roleCombobox').val()
		  };
		$.ajax({
		  url: '/user/edit/'+criteria,
		  type: 'POST',
		  dataType: 'json',
		  data: d,
		  success: function(data, textStatus, xhr) {
		    // alert(data);
		    console.log(data);
		    $.unblockUI();
		    updateSelectList(0);
		  }
		});
	}
}
function archiveItem () {
	$("#archiveDialog").dialog({
		resizable: false,
		height:200,
		modal: true,
		buttons: {
			"Archive user": function() {
				$( this ).dialog( "close" );
				var list = (tabFlag ===0?userSelectList:disabledUserSelectList)
				var row = list.selectedItem.split('_')[1];
			    var idval = list.list[row].id;
				$.ajax({
					  url: '/user/archive/'+idval,
					  type: 'POST',
					  dataType: 'json',
					  success: function(data, textStatus, xhr) {
					    updateSelectList(0);
					    updateSelectList(1);
					  }
					});
			},
			Cancel: function() {
			  $( this ).dialog( "close" );
			}
		}
	});
	
}
function unarchiveItem () {
	$("#unarchiveDialog").dialog({
		resizable: true,
		height:200,
		width: 450,
		modal: true,
		buttons: {
			"Ok": function() {
				$( this ).dialog( "close" );
				var list = (tabFlag ===0?userSelectList:disabledUserSelectList)
				var row = list.selectedItem.split('_')[1];
			    var idval = list.list[row].id;
				$.ajax({
					  url: '/user/unarchive/'+idval,
					  type: 'POST',
					  dataType: 'json',
					  success: function(data, textStatus, xhr) {
					    updateSelectList(0);
					    updateSelectList(1);
					  }
					});
			},
			Cancel: function() {
			  $( this ).dialog( "close" );
			}
		}
	});
	
}
</script>
@endsection
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
.ui-combobox {
    position: relative;
    display: inline-block;
  }
.ui-combobox-toggle {
	position: absolute;
	top: 0;
	bottom: 0;
	margin-left: -1px;
	padding: 0;
	/* support: IE7 
	*height: 1.7em;
	*top: 0.1em;
	*/
}
.ui-combobox-input {
	margin: 0;
	padding: 0.3em;
}
</style>
@endsection
