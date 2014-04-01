<ul class="breadcrumb">
	  <li><a href="/account/manage">Main</a> <span class="divider">/</span></li>
	  <li class="active">Reports</li>
</ul>

<div style="row-fluid">
	<div class="tabs span8">
		<div id="report"  onclick="">
			<div class="searchFor">Enter the reports name or id:</div>
				<div class="searchBox">
					<input type="text" name="reportSelectList_criteria" id="reportSelectList_criteria" maxlength="100" style="width:80%" value="Modular Reports: To Be Implemented">
					<button id="searchReportsButton" class="searchButton" onclick="updateReportSelectList();"><i class="icon-search icon4x"></i>Go</button>
				</div>
			<div class="listColumns">
				<div class="listColumn column1" >Name</div>
				<div class="listColumn column2" >ID</div>
			</div>
			<div class="selectList" id="reportSelectListContent"></div>
		</div>
	</div>
	<div  class="span3">
		<form action="" method="POST" id="reportButtons">
			<input type="hidden" name="reportID" value="" id="reportID" />
			<?php if(Auth::user()->can('reportTemplateCreation')){ ?>
			<button id="editReportButton" class="span12" disabled="disabled" onclick="if(!buttonDisabled(this))submitReport('report/edit')"><i class="icon-edit icon4x"></i>Edit</button>
			<?php } ?>
			<?php if(Auth::user()->can('reportGeneration')){ ?>
			<button id="generateReportButton" class="span12" disabled="disabled" onclick="if(!buttonDisabled(this))submitReport('report/generate')"><i class="icon-plus-sign icon4x"></i>Generate Report</button>
			<?php } ?>
			<?php if(Auth::user()->can('reportGeneration')){ ?>
			<button id="generateERSReportButton" class="span12"><i class="icon-plus-sign icon4x"></i>Generate ERS Report</button>
			<?php } ?>
		</form>
	</div>
</div>
@section('scripts')
<!-- @parent -->
<script type="text/javascript" src="/js/SelectList.js"></script>
<script type="text/javascript" src="/js/jQuery/jquery.blockUI.js"></script>
<script type="text/javascript">
	var reportSelectList = new SelectList('reportSelectList');
	$(function () {
		$("button").button();
		updateReportSelectList();
		$('#generateERSReportButton').click(function(event){
			event.preventDefault();
			if(!buttonDisabled(this)){
				submitERSReport();
			}
		}); 
		// $('#generateManagerReportButton').click(function(event){
			// event.preventDefault();
			// if(!buttonDisabled(this)){
				// submitManagerReport();
			// }
		// }); 
	});
	function updateReportSelectList(){
		var content= "reportSelectListContent";
	$("#"+content).block({
			message:'<div style="font-family:Arial;font-weight:bold;">Loading . . . <img src="/img/loading.gif" style="vertical-align:middle;"></div>',
			css: {
				border:                     'none',
				padding:                    '15px',
				backgroundColor:            '#000',
				'-webkit-border-radius':    '10px',
				'-moz-border-radius':       '10px',
				opacity:                    .5,
				color:                      '#fff'
			}
		});
	var criteria= $("#reportSelectList_criteria").val();
		
	$.ajax({
			url: "/report/find/" ,
			data: {
				criteria: criteria
		},
			type: "POST",
			dataType: "json",
			error: function(XMLHttpRequest, textStatus, errorThrown){
				alert("Request failed: getting data" + textStatus + " " + errorThrown);
				$("#myemployeesSelectList").unblock();
			},
			success: function(msg){
					reportSelectList.list = msg;
					updateReports(reportSelectList.list, "reportSelectList");
				$("#"+content).unblock();
			}
		});
	}
	function updateReports(reports, listID)
	{
		console.log(reports);
		var theHTML = '';
	  var organization = 0;
		var rowOffset = 0;
		var groups = 0;
		for (var row=0; row<reports.length; row++){
			theHTML += '<div id="'+ listID +'profile_' + row + '" class="selectItem' + ((row+rowOffset) % 2 == 0 ? 'Even' : 'Odd') + '" onclick="'+listID+'.clickItem(this)" ondblclick="'+listID+'.clickItem(this);if('+listID+'.selectedItem.length > 0)submitReport(\'report/edit\');"  data-reportID="'+reports[row].id+'">';
			theHTML += '<div class="column1">'+ reports[row].reportname + '</div>';
			theHTML += '<div class="column2">' + reports[row].id +'</div>';        
			theHTML +=  '</div>';
		}
		$("#" + listID + "Content").html(theHTML);
	}
	function submitReport (formLocation) {
		if(formLocation === 'report/create'){
				 $("#reportButtons").attr('action','/' + formLocation);
				$("#reportButtons").submit();
			}else
			if (reportSelectList.selectedItem != 0){
				var idval = reportSelectList.list[reportSelectList.selectedItem.split('_')[1]].id;
				$("#reportID")[0].value = idval;
				$("#reportButtons").attr('action','/' + formLocation + '/' + idval );
				$("#reportButtons").submit();
		}
	}
	function submitERSReport () {
		$("#generateERSReportButton").attr('disabled', 'disabled');
		$.ajax({
			url: "/report/generateERS",
			type: "POST",
			dataType: "json",
			error: function(XMLHttpRequest, textStatus, errorThrown){
				alert("Request failed: getting ERS: " + textStatus + " " + errorThrown);
			},
			success: function(msg){
					var iframe = document.createElement("iframe");
					iframe.style.display = "none";
					iframe.src = msg.filename;
					$('body').append(iframe);
					$("#generateERSReportButton").removeAttr('disabled', 'disabled');
			}
		});
	}
		function submitManagerReport () {
		$("#generateERSReportButton").attr('disabled', 'disabled');
		$.ajax({
			url: "/report/generatManager",
			type: "POST",
			dataType: "json",
			error: function(XMLHttpRequest, textStatus, errorThrown){
				alert("Request failed: getting Manager: " + textStatus + " " + errorThrown);
			},
			success: function(msg){
					var iframe = document.createElement("iframe");
					iframe.style.display = "none";
					iframe.src = msg.filename;
					$('body').append(iframe);
					$("#generateManagereportButton").removeAttr('disabled', 'disabled');
			}
		});
	}
	function myReportsButtons(){
			var disabled = (reportSelectList.selectedItem == 0);
			if (disabled){
				$("button").button('disable')
			}
			else{
				$("button").button('enable')
			}
		}
	reportSelectList.updateButtons = myReportsButtons;
</script>
@endsection
@section('styles')
<!-- @parent -->
<style type="text/css">
	.column1{
	width:          48%;
	float:          left;
	white-space:    nowrap;
}
.column2{
	width:          48%;
	float:          left;
	white-space:    nowrap;
	/*text-align:     right;*/
}
.listColumn{
	background-color:#00A305;
	color:white;
	font-size:medium;
}
.searchButton{
	margin-top:-8px;
}
#buttons{
	float: right;
	padding-top: 120px;
}
div[id^="form_"]{
	height: 100%
}
</style>
<link rel="stylesheet" href="/styles/css/selectList.css">
@endsection