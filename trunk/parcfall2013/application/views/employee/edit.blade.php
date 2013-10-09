<ul class="breadcrumb">
  <li><a href="/account/manage">Employees</a> <span class="divider">/</span></li>
  <li class="active">Edit {{$employee->firstname}} {{$employee->lastname}}</li>
</ul>
<div class="row-fluid">
	<div id="outerTabs">
		<ul>
		 <?php foreach ($programs as $program): ?>
		 <?php if(count($program->forms) > 0) {?>
			<li><a href="#prog_{{$program->id}}">{{$program->programname}}</a></li>
			<?php } ?>
			<?php endforeach ?>
		</ul>
		<?php foreach ($programs as $program): ?>
			<?php if(count($program->forms) > 0) {?>
				<div id="prog_{{$program->id}}">
				<div class="row-fluid">
					<div class="innerTabs">
						<ul>
							<?php foreach ($program->forms as $form): ?>
								<li><a href="#form_{{$form->id}}">{{$form->formname}}</a></li>
							<?php endforeach ?>
						</ul>
						<?php foreach ($program->forms as $form): ?>
							<div id="form_{{$form->id}}">
								<input type="hidden" class="formIDs" value="{{$form->id}}">
								<?php foreach ($form->questions as $question): ?>
									<div class="control-group">
										<label class="control-label" data-questionID="{{$question->id}}" for="input{{$question->id}}">{{$question->questiontext}}:</label>
										<div class="controls">
											<?php
											if(array_key_exists($form->id, $employee->forms) AND array_key_exists("$question->id", $employee->forms[$form->id]['responses'])) {
												$val = $employee->forms[$form->id]['responses']["$question->id"];
											}else
												$val= ''
											?>
											<?php //FieldTypes 1=textbox 2=combobox 3=datepicker 4=numeric 5=checkbox
											if($question->fieldtype == 2) {
												if($question->alt_id != NULL){
													$comboValues = Comboboxfield::getCombo($question->alt_id);
												}else{
													$comboValues = Comboboxfield::getCombo($question->id);
												}?>
													<select name="combo" id="input{{$question->id}}" value="{{$val}}">
														<option></option> 
													@foreach ($comboValues as $key) 												
														<option value="{{$key->id}}"{{($val == $key->id?'selected':'')}}>{{$key->id}}</option> 
													@endforeach
													</select>	
																																																				 
											<?php 
												
											} else if ($question->fieldtype == 3) { ?>
											<!-- datepicker -->
												<input type="text" id="input{{$question->id}}" value="{{$val}}" placeholder="{{$question->questionexample}}" class="date-picker<?php echo ($question->required ? " required" : "");?>"/>
											<?php } else if ($question->fieldtype == 4) { ?>
											<!-- numeric field -->
											<!-- TODO: we need to figure out how to restrict our numeric fields - either here or in our validation later -->
												<input type="text" id="input{{$question->id}}" value="{{$val}}" placeholder="{{$question->questionexample}}" class="<?php echo ($question->required ? "required" : ""); ?>" data-validate="<?php echo $question->validate; ?>" />
											<?php } else if ($question->fieldtype == 5) { ?>
											<!-- checkbox - TODO: I'm still not entirely sure how we want to handle checkboxes-->
												<input type="checkbox" checked="{{$val}}"/>
											<?php } else { ?>
												<!-- This is the standard textbox like we had before -->
												<input type="text" id="input{{$question->id}}" value="{{$val}}" placeholder="{{$question->questionexample}}" class="<?php echo ($question->required ? "required" : ""); ?>" data-validate="<?php echo $question->validate; ?>">
											<?php } ?>
										</div>
									</div>
								<?php endforeach ?>
								<div style="clear:both;"></div>
								<!--<button class="button" onclick="saveForm('form_{{$form->id}}');"><i class="icon-folder-close icon4x"></i>Save</button>-->
								<div style="clear:both;"></div>
							</div>
						<?php endforeach ?>
					</div>
				</div>
				</div>
			<?php } ?>
		<?php endforeach ?>
	</div>
	<button class="button" onclick="saveAll();"><i class="icon-folder-close icon4x"></i>Done &amp; Save All</button>
</div>
@section('styles')
<style type="text/css">
	.innerTabs .control-group{
		float:left;
		padding-right:15px;
	}
	.button{
		float:right;
	}
	.button:after{
		clear:both;
	}

	input[type="text"], input[type="password"] {
        font-size: 16px;
        width: 300px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
    }

    .control-label{
		font-size:18px;
		font-weight: bold;
	}
	.date-picker{

	}
	.numeric{

	}
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
@section('scripts')
<script type="text/javascript" src="/js/jQuery/jquery.blockUI.js"></script>
<script type="text/javascript">
	$(function () {
	  var today = new Date();
		$('#outerTabs').tabs();
		$('.innerTabs').tabs();
		$(".button").button();
		$(".date-picker").datepicker({
		  changeYear:true,
		  changeMonth:true,
		  yearRange:"1900:"+(today.getFullYear()+10)
		});
	});
	function saveAll () {
		var promises = [];
		$(".formIDs").map(function () {
			promises.push(saveForm('form_'+$(this).val()));
		});
		$.when(promises).done(function(){window.location="/account/manage"});
	}
	function saveForm (formID) {
		var questions=[];
		$("#"+formID).children('div').map(function(){
			var qID = $(this).find('label').attr('data-questionID');
			if($('#input'+qID).val() && $('#input'+qID).val().length > 0){
				questions.push({questionid: qID, response: $(this).find('#input'+qID).val()});
			}
		});
		// console.log(questions);
		if(questions.length){
			$("#"+formID).block({
				message:'<div style="font-family:Arial;font-weight:bold;">Saving . . . <img src="/img/loading.gif" style="vertical-align:middle;"></div>',
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
			return $.ajax({
					url: "/employee/saveForm" ,
					data: {
						employeeID: {{$employee->id}},
						questions: questions,
						formID: formID.split("form_")[1]
					},
					type: "POST",
					dataType: "text",
					error: function(XMLHttpRequest, textStatus, errorThrown){
						$("#"+formID).unblock();
					},
					success: function(msg){
						$("#"+formID).unblock();
					}
				});
		}
	}
</script>
@endsection