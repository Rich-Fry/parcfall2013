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
										<label class="control-label" data-questionID="{{$question->id}}" for="input{{$question->id}}">{{$question->questiontext}}: <span class="errorMessage"></span></label>
										<div class="controls">
											<?php
											if(array_key_exists($form->id, $employee->forms) AND array_key_exists("$question->id", $employee->forms[$form->id]['responses'])) {
												$val = $employee->forms[$form->id]['responses']["$question->id"];
											}else
												$val= ''
											?>
											<?php //FieldTypes 1=textbox 2=combobox 3=datepicker 4=numeric 5=checkbox
											if($question->fieldtype == 2) {
												if($question->alt_id != NULL && $question->alt_id != 0){
													$comboValues = Comboboxfield::getCombo($question->alt_id);
													$defaultValues = Comboboxfield::getDefault($question->alt_id);
												}else{
													$comboValues = Comboboxfield::getCombo($question->id);
													$defaultValues = Comboboxfield::getDefault($question->id);
												}
												?>
												<select name="combo"  id="input{{$question->id}}" value="{{$val}}" placeholder="{{$question->questionexample}}" class="<?php echo ($question->required ? "required" : ""); ?> combobox" <?php echo $question->validate == null ? "" : 'data-validate="'.$question->validate.'"'; ?> />
												<option></option>
													@foreach ($comboValues as $key)
														<option value="{{$key->id}}"<?php if ($val == $key->id) echo 'selected="selected"';?> >{{$key->id}} </option>
													@endforeach
													</select>

											<?php

											} else if ($question->fieldtype == 3) { ?>
											<!-- datepicker -->
												<input type="text" id="input{{$question->id}}" value="{{$val}}" placeholder="{{$question->questionexample}}" class="date-picker<?php echo ($question->required ? " required" : "");?>"/>
											<?php } else if ($question->fieldtype == 4) { ?>
											<!-- numeric field -->
											<!-- TODO: we need to figure out how to restrict our numeric fields - either here or in our validation later -->
												<input type="text" id="input{{$question->id}}" value="{{$val}}" placeholder="{{$question->questionexample}}" class="<?php echo ($question->required ? "required" : ""); ?>" <?php echo $question->validate == null ? "" : 'data-validate="'.$question->validate.'"'; ?> />
											<?php } else if ($question->fieldtype == 5) { ?>
											<!-- checkbox - TODO: I'm still not entirely sure how we want to handle checkboxes-->
												<input type="checkbox" checked="{{$val}}"/>
											<?php } else { ?>
												<!-- This is the standard textbox like we had before -->
												<input type="text" id="input{{$question->id}}" value="{{$val}}" placeholder="{{$question->questionexample}}" class="<?php echo ($question->required ? "required" : ""); ?>" <?php echo $question->validate == null ? "" : 'data-validate="'.$question->validate.'"'; ?> />
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
	<!-- Modal -->
        <div id="saveAlert" title="Oops!" style="display:none">
             <p>You have some errors in the form that need to be fixed before you can move on.</p>
        </div>
</div>
@section('styles')
<link rel="stylesheet" href="/styles/css/selectList.css">
<style type="text/css">
	.innerTabs .control-group{
		float:left;
		padding-right:15px;
		height: 75px
	}
	.button{
		float:right;
	}
	.button:after{
		clear:both;
	}

	input[type="text"], input[type="password"], .combo {
        font-size: 16px;
        width: 200px;
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
     .errorMessage{
          color:#F00;
    }
	.combobox {
		font-size: 16px;
	 	height: auto;
	 	width: 220px;
	 	margin-bottom: 15px;
        padding: 7px 9px;
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
          $('.required').focusout(function(){
                 if($(this).val() == "" || $(this).val() == null || $.trim($(this).val()) == ""){
                      var id = $(this).attr("id");
                      $('label[for='+id+'] .errorMessage').text('Required!');
                 }
            }).focusin(function(){
                 var id = $(this).attr("id");
                 $('label[for='+id+'] .errorMessage').text('');
            }).change(function(){
                 if($(this).val() != "" && $(this).val() != null){
                      var id = $(this).attr("id");
                      $('label[for='+id+'] .errorMessage').text('');
                 }
            });
            $('input[data-validate]').focusout(function(){
            	  var validate = $(this).attr('data-validate');
            	  if(!/Address1|Address2|City|State|Zip/.test(validate)){
	                 var regex = new RegExp(validate);
	                 var id = $(this).attr("id");
	                 if(!regex.test($(this).val())){
	                      $('label[for='+id+'] .errorMessage').text('Not Valid');
	                 }
                 }
            });
	});
	function saveAll () {
	     var valid = true;
	     $('.required').each(function(index){
	          if($(this).val() == "" || $(this).val() == null || $.trim($(this).val()) == ""){
	               valid = false;
	               $(this).focusout();
	          }
	     });
	     $('input[data-validate]').each(function(index){
			var validate = $(this).attr('data-validate');
			if(!/Address1|Address2|City|State|Zip/.test(validate)){
				var regex = new RegExp(validate);
				if(!regex.test($(this).val())){
					valid = false;
					$(this).focusout();
				}
			}
	     });

		//TODO: Remove this when moved to production server with usps
	     if(valid === true){
	          var promises = [];
	          $(".formIDs").map(function(){
	               promises.push(saveForm('form_'+$(this).val()));
	          });
	          $.when(promises).done(function(){
	               window.location = "/account/manage";
	          })
	     }else{
	          $('#saveAlert').dialog({
	               modal: true,
	               buttons: {
	                    Close: function(){
	                         $(this).dialog('close');
	                    }
	               }
	          });
	     }
	     //TODO: Remove to here

		/*TODO: Uncomment the following when moved to production server
		var address1 = $("input[data-validate='Address1']").val();
		var address2 = $("input[data-validate='Address2']").val();
		var city = $("input[data-validate='City']").val();
		var state = $("select[data-validate='State']").val();
		var zip = $("input[data-validate='Zip']").val();

		var address1Id = $("input[data-validate='Address1']").attr('id');
		var address2Id = $("input[data-validate='Address2']").attr('id');
		var cityId = $("input[data-validate='City']").attr('id');
		var stateId = $("select[data-validate='State']").attr('id');
		var zipId = $("input[data-validate='Zip']").attr('id');

		$.ajax({
			url:"/employee/validateAddress",
			data:{
				"Address1":address1,
				"Address2":address2,
				"City":city,
				"State":state,
				"Zip":zip
			},
			type: "POST",
			dataType: "json",
			error: function(data, status, error){
				// throw some kind of error
			},
			success: function(data){
				console.log(data);
				if(data.Error == true){
					console.log(address1Id);

					$('label[for='+address1Id+'] .errorMessage').text('Not Valid');
					$('label[for='+address2Id+'] .errorMessage').text('Not Valid');
					$('label[for='+cityId+'] .errorMessage').text('Not Valid');
					$('label[for='+stateId+'] .errorMessage').text('Not Valid');
					$('label[for='+zipId+'] .errorMessage').text('Not Valid');
					valid = false;
				}
			     if(valid === true){
			          var promises = [];
			          $(".formIDs").map(function(){
			               promises.push(saveForm('form_'+$(this).val()));
			          });
			          $.when(promises).done(function(){
			               window.location = "/account/manage";
			          })
			     }else{
			          $('#saveAlert').dialog({
			               modal: true,
			               buttons: {
			                    Close: function(){
			                         $(this).dialog('close');
			                    }
			               }
			          });
			     }
			}
		});
		*/
  	}
	function saveForm (formID) {
		var questions=[];
		var valid = true;
		$("#"+formID).children('div').map(function(){
			var qID = $(this).find('label').attr('data-questionID');
			if($('#input'+qID).val() && $('#input'+qID).val().length > 0){
				questions.push({questionid: qID, response: $(this).find('#input'+qID).val()});
			}
		});
		if(questions.length && valid){
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