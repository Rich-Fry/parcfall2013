<ul class="breadcrumb">
	  <li><a href="/account/manage">Main</a> <span class="divider">/</span></li>
	  <li class="active">Programs</li>
</ul>

<div style="row-fluid">
	<div class="tabs span8">
		<ul>
			<li><a href="#active" onclick="tabFlag=0;programSelectList.updateButtons();">Active Programs</a></li>
			<li><a href="#archived" onclick="tabFlag=1;archivedprogramSelectList.updateButtons();">Archived Programs</a></li>
		</ul>
		<div id="active">
			<div id="programSelectList" >
				<div class="searchFor">Enter the program name or id:</div>
				<div class="searchBox">
					<input type="text" name="programSelectList_criteria" id="programSelectList_criteria" maxlength="100" style="width:80%" >
					<button id="searchActiveButton" class="searchButton" onclick="updateSelectList(0);"><i class="icon-search icon4x"></i>Go</button>
				</div>
				<div class="listColumns">
					<div class="listColumn column1" >Program Name</div>
					<div class="listColumn column2" >Date Modified</div>
				</div>
				<div class="selectList" id="programSelectListContent" style="margin-left:0;">
				</div>
			</div>
		</div>
		<div id="archived">
			<div id="archivedprogramSelectList" >
				<div class="searchFor">Enter the program name or id:</div>
				<div class="searchBox">
					<input type="text" name="archivedprogramSelectList_criteria" id="archivedprogramSelectList_criteria" maxlength="100" style="width:80%" >
					<button id="searchArchivedButton" class="searchButton" onclick="updateSelectList(1);"><i class="icon-search icon4x"></i>Go</button>
				</div>
				<div class="listColumns">
					<div class="listColumn column1" >Program Name</div>
					<div class="listColumn column2" >Date Modified</div>
				</div>
				<div class="selectList" id="archivedprogramSelectListContent" style="margin-left:0;">
				</div>
			</div>
		</div>
	</div>
	<div class="span3">
	<div id="buttons" class="row-fluid">
		@if(Auth::user()->can('programCreation'))
			<button id="createItemButton" class="span12" onclick="view('create')"><i class="icon-plus-sign icon4x"></i>Create</button>
			<button id="editItemButton" class="span12" disabled="disabled" onclick="if(!buttonDisabled(this))view('edit')"><i class="icon-edit icon4x"></i>Edit</button>
		@endif
		<button id="viewItemButton" class="span12" disabled="disabled" onclick="if(!buttonDisabled(this))view('view')"><i class="icon-eye-open icon4x"></i>View</button>
		@if(Auth::user()->can('programDeletion'))
			<button id="archiveItemButton" class="span12" disabled="disabled" ><i class="icon-trash icon4x"></i>Archive</button>
		@endif
	</div>
	</div>
</div>
<div id="archiveDialog" style="display:none;">
	<p><i class="icon-warning-sign"></i>This will archive all Employees/Clients associated with this program as well.  Are you sure you'd like to archive this program?</p>
</div>
<div id="unarchiveDialog" style="display:none;">
	<p><i class="icon-warning-sign"></i>Would you like to unarchive all Employees/Clients in this program as well?</p>
</div>
<script type="text/template" id="itemTemplate">

<div class="modalDisplay" id="itemDisplay" title="Create New Program">
	<div class="modalContent text-center">
		<form id="AddItem" method="POST" onsubmit="return false;">
		 <div id="info">
			<div style="margin-left:0" class="control-group">
		        <label class="control-label" for="itemName">Name:</label>
		        <div class="controls">
		            <input type="text" id="programName" name="name" value="<%= (typeof programname !== 'undefined'? programname : '')%>" <%= (typeof viewing !=="undefined" && viewing === true?'disabled="disabled"':'') %> placeholder="Human Resources"/>
		        </div>
		    </div>
		    <div style="margin-left:0" class="control-group">
		        <label class="control-label" for="description">Description:</label>
		        <div class="controls">
		            <textarea rows="2" cols="50" id="programDescription" name="description" <%= (typeof viewing !=="undefined" && viewing === true?'disabled="disabled"':'') %>><%= (typeof programdescription !== 'undefined'? programdescription : '') %></textarea>
		        </div>
		    </div>
		 </div>
		 </form>
		</div>
	</div>

</script>
@section('scripts')
<script type="text/javascript" src="/js/SelectList.js"></script>
<script type="text/javascript" src="/js/jQuery/jquery.blockUI.js"></script>
<script type="text/javascript">
$(function(){
	$('button').button();
	programSelectList.updateButtons();
	$(".tabs").tabs();
	printSelectList(0);
	printSelectList(1);

});



var tabFlag = 0;
var programSelectList = new SelectList('programSelectList');
var archivedprogramSelectList = new SelectList('archivedprogramSelectList');
var tmpl = _.template($('#itemTemplate').html());
programSelectList.list = {{Response::eloquent($programs)}};
archivedprogramSelectList.list = {{Response::eloquent($archivedprograms)}};
console.log(programSelectList.list);
var buttons = function(){
	var list = (tabFlag ===0?programSelectList:archivedprogramSelectList);
	var disabled = (list.selectedItem == 0);
	$delBtn = $("#archiveItemButton");
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
		$("#editItemButton").button("disable");
		$("#viewItemButton").button("disable");
		$("#archiveItemButton").button("disable");
	}else{
		$("#editItemButton").button("enable");
		$("#viewItemButton").button("enable");
		$("#archiveItemButton").button("enable");
	}
}
programSelectList.updateButtons = buttons;
archivedprogramSelectList.updateButtons = buttons;
function updateSelectList (flag) {
	var content = (flag ===0?"programSelectListContent":"archivedprogramSelectListContent");
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
					var c = $("#"+(flag===0?'programSelectList_criteria':'archivedprogramSelectList_criteria')).val();
					if(c.length>0)
						d['criteria'] = c;
					jQuery.ajax({
						  url: '/program/read/'+flag,
						  type: 'POST',
						  data:d,
						  dataType: 'json',
					 	  success: function(data, textStatus, xhr) {
					 	  	if(flag === 0)
					 	  		programSelectList.list = data;
					 	  	else
					 	  		archivedprogramSelectList.list = data;
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
	var content = (flag ===0?"programSelectListContent":"archivedprogramSelectListContent");
	var list = (flag ===0?programSelectList:archivedprogramSelectList);
	for (var row=0; row < list.list.length; row++){
			theHTML += '<div id="'+(flag ===0?'programSelectList':'archivedprogramSelectList')+'program_' + row + '" class="selectItem' + ((row) % 2 == 0 ? 'Even' : 'Odd') + '" onclick="'+(flag ===0?"programSelectList":"archivedprogramSelectList")+'.clickItem(this)" ondblclick="'+(flag ===0?"programSelectList":"archivedprogramSelectList")+'.clickItem(this);if('+(flag ===0?"programSelectList":"archivedprogramSelectList")+'.selectedItem.length > 0)view(\'view\');"  data-itemID="'+list.list[row].id+'">';
			theHTML += '<div class="column1">'+ list.list[row].programname + '</div>';
			theHTML += '<div class="column2">'+ list.list[row].updated_at + '</div>';
			theHTML +=  '</div>';
		}
		$("#"+content).html(theHTML);
}
function view (type) {
	var msg;
	var b;
	var validator;
	var list = (tabFlag ===0?programSelectList:archivedprogramSelectList);
	if(type=="edit"){
		if (list.selectedItem.length > 0){
        	var row = list.selectedItem.split('_')[1];
        	list.list[row].viewing= false;
			msg = tmpl(list.list[row]);
			b = {
				Save: function(){
					if(validator.form()){
						itemSave(list.list[row].id)
						$(this).dialog('close');
					}
				},
				Close: function(){
					$(this).dialog('close');
				}
			}
		}
	}else if(type=="create"){
		msg = tmpl({});
		b = {
			Create: function(){
				if(validator.form()){
					itemSave('create');
					$(this).dialog('close');
				}
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
					$(this).dialog('close');
				}
			}
		}
	}
	
	$(msg).dialog({
		resizable: true,
		height:300,
		width: 300,
		modal: true,
		buttons: b,
		open: function () {
			if(type === 'create'){
				var btnCreate = $('.ui-dialog-buttonpane').find( 'button:contains("Create")' );
				btnCreate.prepend('<i class="icon-plus-sign icon4x" style="float:left;padding-top:8px;padding-left:10px;"></i>');
				btnCreate.width(btnCreate.width() + 25);
				var btnCancel = $('.ui-dialog-buttonpane').find( 'button:contains("Cancel")' );
				btnCancel.prepend('<i class="icon-remove icon4x" style="float:left;padding-top:8px;padding-left:10px;"></i>');
				btnCancel.width(btnCancel.width() + 25);
			}else if(type === 'edit'){
				var btnSave = $('.ui-dialog-buttonpane').find( 'button:contains("Save")' );
				btnSave.prepend('<i class="icon-folder-close icon4x" style="float:left;padding-top:8px;padding-left:10px;"></i>');
				btnSave.width(btnSave.width() + 25);
				var btnClose = $('.ui-dialog-buttonpane').find( 'button:contains("Close")' );
				btnClose.prepend('<i class="icon-remove icon4x" style="float:left;padding-top:8px;padding-left:10px;"></i>');
				btnClose.width(btnClose.width() + 25);
			}else if(type === 'view'){
				var btnClose = $('.ui-dialog-buttonpane').find( 'button:contains("Close")' );
				btnClose.prepend('<i class="icon-remove icon4x" style="float:left;padding-top:8px;padding-left:10px;"></i>');
				btnClose.width(btnClose.width() + 25);
			}
			if(type!=='view'){
        		validator = $("#AddItem").validate({
	        		submitHandler: function(form){
	        			if(type==='create'){
	        				itemSave('create')
	        			}else{
	        				itemSave(list.list[row].id)
	        			}
	        		},
					rules:{
						name:{
							required: true
						},
						description:{
							required: true
						}
					},

					messages:{
						name: {
							required: "Please enter a name for this program"
						},
						description: {
							required: "Please enter a description for this program"
						}
					}
				});
        	}
        	$('button').button();
        	if(type !== 'view')
	        	$(".datepicker").datepicker({
		            buttonImage: '/img/calendar.gif',
		            buttonImageOnly: true,
		            showButtonPanel: true,
		            showOn: 'both', 
		            buttonText: 'Show Calendar',
		            minDate: new Date(),
		            onSelect: function(dateText, inst) {
		                $(this).attr('value',dateText);
		            }
	        	});
		},
		close: function(){
			$(this).remove();
		}
	})
	
}
function itemSave (criteria) {
	var d = {
		  	programName: $('#programName').val(),
		  	programDescription: $('#programDescription').val()
		  };
	if(criteria === 'create'){
		
		$.ajax({
		  url: '/program/create',
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
		$.ajax({
		  url: '/program/edit/'+criteria,
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
			"Archive Program": function() {
				$( this ).dialog( "close" );
				var list = (tabFlag ===0?programSelectList:archivedprogramSelectList)
				var row = list.selectedItem.split('_')[1];
			    var idval = list.list[row].id;
				$.ajax({
					  url: '/program/archive/'+idval,
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
			"Program&Employees": function() {
				$( this ).dialog( "close" );
				var list = (tabFlag ===0?programSelectList:archivedprogramSelectList)
				var row = list.selectedItem.split('_')[1];
			    var idval = list.list[row].id;
				$.ajax({
					  url: '/program/unarchive/'+idval,
					  type: 'POST',
					   data: {
					  	unarchiveEmployees: true
					  },
					  dataType: 'json',
					  success: function(data, textStatus, xhr) {
					    updateSelectList(0);
					    updateSelectList(1);
					  }
					});
			},
			"Program": function() {
				$( this ).dialog( "close" );
				var list = (tabFlag ===0?programSelectList:archivedprogramSelectList)
				var row = list.selectedItem.split('_')[1];
			    var idval = list.list[row].id;
				$.ajax({
					  url: '/program/unarchive/'+idval,
					  type: 'POST',
					  data: {
					  	unarchiveEmployees: false
					  },
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
</style>
@endsection