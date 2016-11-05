@if (isset($request))
<label>Location Name:</label> {{ $request->name }} <br />
<label>Location Address:</label> {{ $request->address }} <br />
<label>Difficulty:</label> {{ $request->difficulty }} <br />
<label>Distance:</label> {{ $request->distance }} <br />
<label>Description:</label> @if (isset($request->description)) {{ $request->description }} @endif <br />
<label>URL:</label> <a href="{{ $request->web }}">{{ $request->web }}</a>
@endif