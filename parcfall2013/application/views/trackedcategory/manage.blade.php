<ul class="breadcrumb">
	  <li><a href="/account/manage">Main</a> <span class="divider">/</span></li>
	  <li class="active">Tracked Item Categories</li>
</ul>

<div style="row-fluid">
	<div class="tabs span8">
		<ul>
			<li><a href="#active" onclick="tabFlag=0;categorySelectList.updateButtons();">Active Categories</a></li>
			<li><a href="#archived" onclick="tabFlag=1;archivedCategorySelectList.updateButtons();">Archived Categories</a></li>
		</ul>
		<div id="active">
			<div id="categorySelectList" >
				<div class="searchFor">Enter the tracked category name or id:</div>
				<div class="searchBox">
					<input type="text" name="categorySelectList_criteria" id="categorySelectList_criteria" maxlength="100" style="width:80%" >
					<button id="searchActiveButton" class="searchButton" onclick="updateSelectList(0);"><i class="icon-search icon4x"></i>Go</button>
				</div>
				<div class="listColumns">
					<div class="listColumn column1" >Category Name</div>
					<div class="listColumn column2" >Date Modified</div>
					<div class="listColumn column3" >Template Name</div>
				</div>
				<div class="selectList" id="categorySelectListContent" style="margin-left:0;">
				</div>
			</div>
		</div>
		<div id="archived">
			<div id="archivedCategorySelectList" >
				<div class="searchFor">Enter the tracked category name or id:</div>
				<div class="searchBox">
					<input type="text" name="archivedCategorySelectList_criteria" id="archivedCategorySelectList_criteria" maxlength="100" style="width:80%" >
					<button id="searchArchivedButton" class="searchButton" onclick="updateSelectList(1);"><i class="icon-search icon4x"></i>Go</button>
				</div>
				<div class="listColumns">
					<div class="listColumn column1" >Category Name</div>
					<div class="listColumn column2" >Date Modified</div>
					<div class="listColumn column3" >Template Name</div>
				</div>
				<div class="selectList" id="archivedCategorySelectListContent" style="margin-left:0;">
				</div>
			</div>
		</div>
	</div>
	<div class="span3">
	<div id="buttons" class="row-fluid">
		@if(Auth::user()->can('trackedItemCreation'))
			<button id="createItemButton" class="span12" onclick="view('create')"><i class="icon-plus-sign icon4x"></i>Create</button>
			<button id="editItemButton" class="span12" disabled="disabled" onclick="if(!buttonDisabled(this))view('edit')"><i class="icon-edit icon4x"></i>Edit</button>
		@endif
		<button id="viewItemButton" class="span12" disabled="disabled" onclick="if(!buttonDisabled(this))view('view')"><i class="icon-eye-open icon4x"></i>View</button>
		@if(Auth::user()->can('trackedTemplateCreation'))
			<button id="createTemplate" class="span12" disabled="disabled" onclick="if(!buttonDisabled(this))createTemplate()"><i class="icon-edit icon4x"></i>Create/Edit Template</button>
		@endif
		<button id="viewTemplate" class="span12" disabled="disabled" onclick="if(!buttonDisabled(this))view('template')"><i class="icon-eye-open icon4x"></i>View Template</button>
		@if(Auth::user()->can('trackedTemplateCreation'))
			<button id="deleteItemButton" class="span12" disabled="disabled" ><i class="icon-trash icon4x"></i>Archive</button>
		@endif
	</div>
	</div>
</div>
<div id="deleteDialog" style="display:none;">
	<p><i class="icon-warning-sign"></i>This will delete all items associated with this Category as well.  Are you sure you'd like to delete this category?</p>
</div>
<div id="undeleteDialog" style="display:none;">
	<p><i class="icon-warning-sign"></i>Would you like to undelete all items in this category as well?</p>
</div>
<script type="text/template" id="itemTemplate">

<div class="modalDisplay" id="itemDisplay" title="Create New Category">
	<div class="modalContent text-center">
		<form id="AddItem" method="POST" onsubmit="return false;">
		 <div id="info">
			<div style="margin-left:0" class="control-group">
		        <label class="control-label" for="itemName">Name:</label>
		        <div class="controls">
		            <input type="text" id="categoryName" name="name" value="<%= (typeof categoryname !== 'undefined'? categoryname : '')%>" <%= (typeof viewing !=="undefined" && viewing === true?'disabled="disabled"':'') %> placeholder="Human Resources"/>
		        </div>
		    </div>
		    <div style="margin-left:0" class="control-group">
		        <label class="control-label" for="description">Description:</label>
		        <div class="controls">
		            <textarea rows="2" cols="50" id="categoryDescription" name="description" <%= (typeof viewing !=="undefined" && viewing === true?'disabled="disabled"':'') %>><%= (typeof categorydescription !== 'undefined'? categorydescription : '') %></textarea>
		        </div>
		    </div>
		
		 </div>
		 </form>
		</div>
	</div>

</script>
<script type="text/template" id="templateDisplay">
<div class="modalDisplay" id="trackedTemplateTemplate" title="Create Category Template">
	<div style="margin-left:0" class="control-group">
        <label class="control-label" for="templateName">Name:</label>
        <div class="controls">
            <input type="text" id="templateName" name="name" value="<%= (typeof templatename !== 'undefined'? templatename : '')%>" <%= (typeof viewing !=="undefined" && viewing === true?'disabled="disabled"':'') %> placeholder="Human Resources"/>
        </div>
    </div>
    <div style="margin-left:0" class="control-group">
        <label class="control-label" for="description">Description:</label>
        <div class="controls">
            <textarea rows="2" cols="50" id="templateDescription" name="description" <%= (typeof viewing !=="undefined" && viewing === true?'disabled="disabled"':'') %>><%= (typeof templatedescription !== 'undefined'? templatedescription : '') %></textarea>
        </div>
    </div>
	<div id="fieldList">
		<ul class="fields">
			<% if( typeof templateFields !== 'undefined' && templateFields instanceof Array && templateFields.length > 0){ %>
				<% _.each(templateFields, function(field){ %>
					<%= fieldTemplate({item: field, viewing: viewing}) %>
				<% }) %>
			<% } %>
		</ul>
	</div>
	<% if(typeof viewing =='undefined' || viewing === false){ %>
		<button id="addField" onclick="addfield(this);">Add New Field</button>
	<% } %>
</div>
</script>
<script type="text/template" id="fieldTemplate">
	<li data-id="<%= (typeof item.id !== 'undefined'? item.id : '')%>" class="ui-widget ui-state-default ui-corner-all">
	<% if(typeof viewing ==="undefined" || viewing === false){%>
		<span class='removeField' onclick="removeField(this)"><i class="icon-minus-sign"></i></span>
	<%}%>
		<div style="margin-left:0" class="control-group">
	        <label class="control-label" for="fieldName">Field Name:</label>
	        <div class="controls">
	            <input type="text" class="fieldName" name="name" value="<%= (typeof item.fieldname !== 'undefined'? item.fieldname : '')%>" <%= (typeof viewing !=="undefined" && viewing === true?'disabled="disabled"':'') %> placeholder="Type of Training"/>
	        </div>
	    </div>
	</li>
</script>

@section('scripts')
<script type="text/javascript" src="/js/SelectList.js"></script>
<script type="text/javascript" src="/js/jQuery/jquery.blockUI.js"></script>
<script type="text/javascript">
$(function(){
	$('button').button();
	categorySelectList.updateButtons();
	$(".tabs").tabs();
	printSelectList(0);
	printSelectList(1);

});



var tabFlag = 0;
var categorySelectList = new SelectList('categorySelectList');
var archivedCategorySelectList = new SelectList('archivedCategorySelectList');
var tmpl = _.template($('#itemTemplate').html());
var fieldTemplate = _.template($("#fieldTemplate").html());
var trackedTemplate = _.template($("#templateDisplay").html())
categorySelectList.list = {{Response::eloquent($trackedcategories)}};
archivedCategorySelectList.list = {{Response::eloquent($archivedcategories)}};
console.log(categorySelectList.list);
function updateButtons (){
	var list = (tabFlag ===0?categorySelectList:archivedCategorySelectList);
	var disabled = (list.selectedItem == 0);
	$delBtn = $("#deleteItemButton");
	if(tabFlag === 1){
		$delBtn.html('<span class="ui-button-text"><i class="icon-trash icon4x"></i>Unarchive</span>');
		$delBtn.off('click',deleteItem);
		$delBtn.on('click',undeleteItem);
	}else{
		$delBtn.html('<span class="ui-button-text"><i class="icon-trash icon4x"></i>Archive</span>');
		$delBtn.off('click',undeleteItem);
		$delBtn.on('click',deleteItem);
	}
	if(disabled){
		$("#editItemButton").button("disable");
		$("#viewItemButton").button("disable");
		$("#deleteItemButton").button("disable");
		$("#createTemplate").button("disable");
		$("#viewTemplate").button("disable");
	}else{
		$("#editItemButton").button("enable");
		$("#viewItemButton").button("enable");
		$("#deleteItemButton").button("enable");
		$("#createTemplate").button("enable");
		var row = list.selectedItem.split('_')[1];
		if(list.list[row].template !== null)
			$("#viewTemplate").button("enable");
		else
			$("#viewTemplate").button("disable");
		if(list.list[row].template === null || (list.list[row].template !== null && list.list[row].template.active === 0))
			$("#createTemplate").button("enable");
		else
			$("#createTemplate").button("disable");
	}
}
categorySelectList.updateButtons = updateButtons;
archivedCategorySelectList.updateButtons = updateButtons;
function updateSelectList (flag) {
	var content = (flag ===0?"categorySelectListContent":"archivedCategorySelectListContent");
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
					var c = $("#"+(flag===0?'categorySelectList_criteria':'archivedCategorySelectList_criteria')).val();
					if(c.length>0)
						d['criteria'] = c;
					jQuery.ajax({
						  url: '/trackedcategory/read/'+flag,
						  type: 'POST',
						  data:d,
						  dataType: 'json',
					 	  success: function(data, textStatus, xhr) {
					 	  	if(flag === 0)
					 	  		categorySelectList.list = data;
					 	  	else
					 	  		archivedCategorySelectList.list = data;
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
	var content = (flag ===0?"categorySelectListContent":"archivedCategorySelectListContent");
	var list = (flag ===0?categorySelectList:archivedCategorySelectList);
	for (var row=0; row < list.list.length; row++){
			theHTML += '<div id="'+(flag ===0?'categorySelectList':'archivedCategorySelectList')+'trackedCategory_' + row + '" class="selectItem' + ((row) % 2 == 0 ? 'Even' : 'Odd') + '" onclick="'+(flag ===0?"categorySelectList":"archivedCategorySelectList")+'.clickItem(this)" ondblclick="'+(flag ===0?"categorySelectList":"archivedCategorySelectList")+'.clickItem(this);if('+(flag ===0?"categorySelectList":"archivedCategorySelectList")+'.selectedItem.length > 0)view(\'view\');"  data-itemID="'+list.list[row].id+'">';
			theHTML += '<div class="column1">'+ list.list[row].categoryname + '</div>';
			theHTML += '<div class="column2">'+ list.list[row].updated_at + '</div>';
			theHTML += '<div class="column3">'+ (list.list[row].template?list.list[row].template.templatename.trunc(15) + '-' + (list.list[row].template.active ===0?'Inactive':'Active'):'None') + '</div>';
			theHTML +=  '</div>';
		}
		$("#"+content).html(theHTML);
}
function view (type) {
	var msg;
	var buttons;
	var validator;
	var h = 300;
	var list = (tabFlag ===0?categorySelectList:archivedCategorySelectList);
	var row = 0;
	if(type==="edit"){
		if (list.selectedItem.length > 0){
        	row = list.selectedItem.split('_')[1];
        	list.list[row].viewing= false;
			msg = tmpl(list.list[row]);
			buttons={
				Save: function () {
					$("#addItem").submit();
					if(validator.form()){
						itemSave(list.list[row].id);
						$(this).dialog('close');
					}
				},
				Cancel: function () {
					$(this).dialog('close');
				}
			}
		}
	}else if(type==="create"){
		msg = tmpl({});
		buttons={
			Create: function () {
				$("#addItem").submit();
				if(validator.form()){
					itemSave('create');
					$(this).dialog('close');
				}
			},
			Cancel: function () {
				$(this).dialog('close');
			}
		}
	}else if(type==="view"){
		if (list.selectedItem.length > 0){
        	row = list.selectedItem.split('_')[1];
        	list.list[row].viewing= true;
			msg = tmpl(list.list[row]);
			buttons = {
        		Close: function () {
        			$(this).dialog('close')
        		}
        	}
		}
	}else if(type==='template'){
		if (list.selectedItem.length > 0){
			h = 500;
        	row = list.selectedItem.split('_')[1];
        	list.list[row].template.viewing= true;
			msg = trackedTemplate(list.list[row].template);
			buttons = {
        		Close: function () {
        			$(this).dialog('close');
        		}
        	}
		}
	}
	if(msg)
	$(msg).dialog({
		resizable: true,
		height:h,
		width: 450,
		modal: true,
		open: function(){
        	if(type!=='view'||type!=='template'){
        		validator = $("#AddItem").validate({
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
							required: "Please enter a name for this category"
						},
						description: {
							required: "Please enter a description for this category"
						}
					}
				});
        	}
        },
        close: function(){
			$(this).remove();
		},
        buttons:buttons
	});
	list.updateButtons();
}
function itemSave (criteria) {
	var d = {
		  	categoryName: $('#categoryName').val(),
		  	categoryDescription: $('#categoryDescription').val()
		  };
	$.ajax({
		url: (criteria === 'create'?'/trackedcategory/create':'/trackedcategory/edit/'+criteria),
		type: 'POST',
		dataType: 'json',
		data: d,
		success: function(data, textStatus, xhr) {
			$.unblockUI();
			updateSelectList(0);
		}
	});
}
function deleteItem () {
	var list = (tabFlag ===0?categorySelectList:archivedCategorySelectList)
	var row = list.selectedItem.split('_')[1];
	$("#deleteDialog").dialog({
		resizable: false,
		height:200,
		modal: true,
		buttons: {
			"Archive Category": function() {
				$( this ).dialog( "close" );
			    var idval = list.list[row].id;
				$.ajax({
					  url: '/trackedcategory/archive/'+idval,
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
function undeleteItem () {
	var list = (tabFlag ===0?categorySelectList:archivedCategorySelectList)
	var row = list.selectedItem.split('_')[1];
	$("#undeleteDialog").dialog({
		resizable: true,
		height:200,
		width: 450,
		modal: true,
		buttons: {
			"Category&Items": function() {
				$( this ).dialog( "close" );
				
			    var idval = list.list[row].id;
				$.ajax({
					  url: '/trackedcategory/unarchive/'+idval,
					  type: 'POST',
					   data: {
					  	undeleteItems: true
					  },
					  dataType: 'json',
					  success: function(data, textStatus, xhr) {
					    updateSelectList(0);
					    updateSelectList(1);
					  }
					});
			},
			"Category": function() {
				$( this ).dialog( "close" );
				var list = (tabFlag ===0?categorySelectList:archivedCategorySelectList)
				var row = list.selectedItem.split('_')[1];
			    var idval = list.list[row].id;
				$.ajax({
					  url: '/trackedcategory/unarchive/'+idval,
					  type: 'POST',
					  data: {
					  	undeleteItems: false
					  },
					  dataType: 'json',
					  success: function(data, textStatus, xhr) {
					    updateSelectList(0);
					    updateSelectList(1);
					  }
					});
			}
		}
	});
}
function createTemplate () {
	var msg;
	var buttons;
	var list = (tabFlag ===0?categorySelectList:archivedCategorySelectList);
	if (list.selectedItem.length > 0){
        	var row = list.selectedItem.split('_')[1];
        	if(list.list[row].template){
        		list.list[row].template.viewing= false;
        		buttons = {
					Save: function () {
						
						var template = {
							categoryID: list.list[row].id,
							templateName: $("#templateName").val(),
							templateDescription: $("#templateDescription").val(),
							fields: []
						};
						$(".fields").children().each(function () {
							if($(this).attr('data-id')==='')
								template.fields.push({
									fieldName: $(this).find('.fieldName').val()
								});
							else
								template.fields.push({
									id: $(this).attr('data-id'),
									fieldName: $(this).find('.fieldName').val()
								});
						});
						$.ajax({
							  url: '/trackedtemplate/edit/'+list.list[row].template.id,
							  type: 'POST',
							   data: template,
							  dataType: 'json',
							  success: function(data, textStatus, xhr) {
								list.list[row].template = data;
							    updateSelectList(0);
							    updateSelectList(1);
							  }
							});
						$( this ).dialog( "close" );
					},
					Cancel: function () {
						$(this).dialog('close');
					}
				}
        	}
        	else{
        		
        		buttons = {
					Create: function () {
						
						var template = {
							categoryID: list.list[row].id,
							templateName: $("#templateName").val(),
							templateDescription: $("#templateDescription").val(),
							fields: []
						};
						$(".fields").children().each(function () {
							template.fields.push({
								fieldName: $(this).find('.fieldName').val()
							});
						});
						$.ajax({
							  url: '/trackedtemplate/create/',
							  type: 'POST',
							   data: template,
							  dataType: 'json',
							  success: function(data, textStatus, xhr) {
								list.list[row].template = data;
							    updateSelectList(0);
							    updateSelectList(1);
							  }
							});
						$( this ).dialog( "close" );
					},
					Cancel: function () {
						$(this).dialog('close');
					}
				}
        	}
			msg = trackedTemplate(list.list[row].template);
		}
	$(msg).dialog({
		resizable: true,
		height:600,
		width: 450,
		modal: true,
		buttons: buttons,
		open: function (event, ui) {
			$(event.target).find('button').button();
		},
		close: function (event, ui) {
        	$(this).remove();
        }
	});
}
function addfield (temp) {
	console.log($(temp).prev())
	$(temp).prev().find('.fields').append(fieldTemplate({item: {}}));
}
function removeField (item) {
	var item = $(item).parent();
	var id = $(item).attr('data-id');
	if(!isNaN(parseInt(id))){
		jQuery.ajax({
		  url: '/trackedtemplate/deletefield/'+id,
		  type: 'POST',		
		  dataType: 'json',
		  success: function(data, textStatus, xhr) {
		  	console.log('success, response:' + data);
		  	updateSelectList(0);
		  	updateSelectList(1);
		  },
		  error: function(xhr, textStatus, errorThrown) {
		    console.log('error, errorthrown:' + errorThrown);
		  }
		});
	}
	$(item).remove();
}
</script>
@endsection
@section('styles')

	<link rel="stylesheet" href="/styles/css/selectList.css">
	<link rel="stylesheet" href="/styles/css/ui.css">
<style>
.column1{
	width: 32%;
    float:left;
    border-right:solid 1px;
    padding: 0 4px;
    white-space: nowrap;
}
.column2{
	width: 32%;
    float:left;
    border-right:solid 1px;
    padding: 0 4px;
    white-space: nowrap;
}
.column3{
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
.removeField{
	cursor: pointer;
	float:right;
}
.fields li{
	list-style: none;
}
.fields{
	margin:0;
}
</style>
@endsection