<div class="ui-widget">
	<ul class="breadcrumb">
	  <li><a href="/account/manage">Main</a> <span class="divider">/</span></li>
	  <li class="active">Edit Report: {{$report->reportName}}</li>
	</ul>
	<div class="ui-widget-content ui-helper-reset ui-corner-all span12">
		<div class="span4">
			<h1 class="ui-widget-header">Programs</h1>
			<div id="outerAccordion">
		 <?php foreach ($programs as $program): ?>
			 <?php if(count($program->forms) > 0) {?>
				<h3>{{$program->programname}}</h3>
					<div>
						<h1 class="ui-widget-header">Forms</h1>
						<div class="innerAccordion">
				<?php foreach ($program->forms as $form): ?>
						<h4>{{$form->formname}}</h4>
						<div id="form_{{$form->id}}">
							<h1 class="ui-widget-header">Form Items</h1>
							<input type="hidden" class="formIDs" value="{{$form->id}}">
							<ul class="formItems">
								<?php foreach ($form->questions as $question): ?>
									<li>
										<div class="formItem" id="{{$question->id}}">
											<div class="itemText">{{$question->questiontext}}</div>
											<div class="itemExample">{{$question->questionexample}}</div>
										</div>
									</li>
								<?php endforeach ?>
							</ul>
						</div>
					
				<?php endforeach ?>
					</div>
				</div>
			<?php } ?>
		<?php endforeach ?>
		  </div>
		</div>
		<div class="span7" id="reportTemplate" class="ui-widget">
			<h1 class="ui-widget-header">Report Template</h1>
			<ul id="report_{{$report->id}}" class="ui-widget-content ui-helper-reset ui-corner-all">
				@foreach($report->questions as $question)
					<li class="currentItem">
						<div class="formItem" id="{{$question->id}}">
							<div class="itemText">{{$question->questiontext}}</div>
							<div class="itemExample">{{$question->questionexample}}</div>
						</div>
					</li>
				@endforeach
				<li class="placeholder">Add your items here</li>
			</ul>
			<button id="saveReport"><i class="icon-folder-close icon4x"></i>Save</button>
		</div>
	</div>
</div>
@section('styles')
<style>
	div.formItem {
		background-color: #C5CFD4;
		width:150px;
		border: 1px solid #C5CFD4;
		max-height: 150px;
		margin: 20px auto;
		padding: 5px;
		-moz-border-radius: 10px 10px 10px 10px;
		-moz-box-shadow:0 1px 10px #666;
		-webkit-border-radius: 10px 10px 10px 10px;
		-webkit-box-shadow:0 1px 10px #666;
		border-radius: 10px 10px 10px 10px;
		box-shadow:0 1px 10px #666;
		cursor: pointer;
	}
	ul{
		list-style-type:none;
	}
	/*ul[id^=report_]{
		height:100%;
	}*/
</style>
@endsection
@section('scripts')
<script type="text/javascript" src="/js/jQuery/jquery.blockUI.js"></script>
<script type="text/javascript">
	$(function() {
		$('button').button({disabled: true});
		$('#outerAccordion').accordion({
			collapsible: false,
			heightStyle: "fill"
		});
		$('.innerAccordion').accordion({
			collapsible: true,
			heightStyle: "content"
		});
		$( ".formItems li" ).draggable({
            appendTo: "body",
            cursor: "move",
            helper: 'clone',
            containment: "document"
        });
        $( "#reportTemplate ul" ).droppable({
            activeClass: "ui-state-default",
            hoverClass: "ui-state-hover",
            accept: ":not(.ui-sortable-helper)",
            drop: function( event, ui ) {
            	$( "button" ).button( "option", "disabled", false );
                $( this ).find( ".placeholder" ).remove();
                $( this ).find( ".currentItem" ).remove();
                $( "<li></li>" ).html( ui.draggable.html() ).appendTo( this);
                deleteItem(ui.draggable);
            }
        }).sortable({
            items: "li:not(.placeholder)",
            sort: function() {
                // gets added unintentionally by droppable interacting with sortable
                // using connectWithSortable fixes this, but doesn't allow you to customize active/hoverClass options
                $( this ).removeClass( "ui-state-default" );
            }
        });
        $("ul[id^=report_]").css('height', $(".span4").css('height'));
        $('#saveReport').click(function() {
        	var items=[];
        	var reportID = {{$report->id}};
			$("#report_"+reportID+" .formItem").map(function(){
				var qID = $(this).attr('id');
				items.push(qID);
			});
			console.log(items);
			$("#report_"+reportID).block({
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
			$.ajax({
					url: "/report/update" ,
					data: {
						items: items,
						reportID: reportID
					},
					type: "POST",
					dataType: "json",
					error: function(XMLHttpRequest, textStatus, errorThrown){
						alert("Request failed: getting data" + textStatus + " " + errorThrown);
						$("#myemployeesSelectList").unblock();
					},
					success: function(msg){
						$("#report_"+reportID).unblock();
						console.log(msg);
					}
				});
        	
        });
	});
	function deleteItem( $item ) {
            $item.fadeOut(function() {
                
            });
        }
</script>
@endsection