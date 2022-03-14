@if ($errors->count()==1)
	<div class="alert alert-danger">
		
			@foreach($errors->all() as $error)
				{{$error}}
			@endforeach
		
	</div>	
@else
	@if ($errors->any())
	<div class="alert alert-danger">
		<ul>
			@foreach($errors->all() as $error)
				<li>{{$error}}</li>
			@endforeach
		</ul>
	</div>
	@endif
@endif