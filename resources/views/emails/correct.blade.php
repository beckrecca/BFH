@if (isset ($request))
<label>Name</label>: {{ $request->name }} <br />
<label>Correction:</label> {{ $request->correction }}
@endif