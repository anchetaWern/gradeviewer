@extends('layouts.main')

@section('sweetalert_style')
<link rel="stylesheet" href="{{ url('assets/lib/sweetalert/sweetalert.min.css') }}">
@stop

@section('content')
<form>
	<h2>Activities</h2>
	<p>
		<label for="title">Title</label>
		<input type="text" name="title" id="title">
	</p>
	<p>
		Component <br>
		<label>
			<input type="radio" name="component" value="lab" checked>
			<span class="checkable">lab</span>
		</label>
		<label>
			<input type="radio" name="component" value="lec">
			<span class="checkable">lec</span>
		</label>
	</p>
	<p>
		<label for="cell">Cell</label>
		<input type="text" name="cell" id="cell">
	</p>			
	<p>
		<label for="type">Type</label>
		<select name="type" id="type">
			@foreach($types as $type)
				<option value="{{ $type }}">{{ ucwords($type) }}</option>
			@endforeach
		</select>
	</p>
	<p>
		<button type="button" id="add">Add</button>
	</p>
</form>

<div id="activities"></div>
@stop

@include('frontend_templates.activities')

@section('sweetalert_script')
<script src="{{ url('assets/lib/sweetalert/sweetalert.min.js') }}"></script>
@stop

@section('handlebars_script')
<script src="{{ url('assets/js/handlebars.min.js') }}"></script>
@stop

@section('activities_script')
<script src="{{ url('assets/js/activities.js') }}"></script>
@stop