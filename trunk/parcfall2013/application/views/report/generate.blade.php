<div class="container">
	<ul class="breadcrumb">
	  <li><a href="/account/manage">Main</a> <span class="divider">/</span></li>
	  <li class="active">Generated Report: {{$template->reportName}}</li>
	</ul>
	<table border='1'>
		<tr>
			<th>ID</th>
			@foreach($template->questions as $question)
			
			    <th>{{$question->questiontext}}</th>
			    
			@endforeach
		</tr>
		
			@foreach($report as $id => $entry)
				<tr>
				<td>{{$entry['employee']->id}}</td>
				@foreach($entry['responses'] as $response)
				
				    <td>{{$response->response}}</td>
				    
				@endforeach
			    </tr>
			@endforeach
		
	</table>
</div>
@section('styles')
<style>
	
</style>
@endsection
@section('scripts')
<script type="text/javascript">
var temp = <?php echo json_encode($report); ?>;
console.log(temp);
</script>
@endsection