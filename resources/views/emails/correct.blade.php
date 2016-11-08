@if (isset($request))
<div>
	<label>Name</label>: {{ $request->name }} <br />
	<label>Wrong:</label> <br/>
	@if (isset ($request->wrong))
		<ul>
		@foreach ($request->wrong as $wrong)
			<li>{{ $wrong }}</li>
		@endforeach
		</ul>
	@endif
	<label>Correction:</label> {{ $request->correction }}
</div>
@endif