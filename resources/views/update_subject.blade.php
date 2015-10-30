@extends('layouts.main')

@section('dropzone_style')
<link rel="stylesheet" href="{{ url('assets/lib/dropzone/dropzone.min.css') }}">
@stop

@section('content')
<h2>Update Subject</h2>
<form action="/upload" class="dropzone" id="uploader">
	<div class="dz-message">Drop .xls files here (Maximum of 2 files)</div>
</form>

<form method="POST">
	<p>
		<label for="title">Subject Title</label>
		<input type="text" name="title" id="title" value="{{ old('title', $subject->title) }}">	
	</p>

	<p>
		<label for="sheet_number">Sheet #</label>
		<input type="text" name="sheet_number" id="sheet_number" value="{{ old('sheet_number', $subject_settings->sheet_number) }}">
	</p>

	<p>
		<label for="name_cell">Name Cell</label>
		<input type="text" name="name_cell" id="name_cell" value="{{ old('name_cell', $subject_settings->name_cell) }}">
	</p>

	<p>
		<label for="grade_cell">Grade Cell</label>
		<input type="text" name="grade_cell" id="grade_cell" value="{{ old('grade_cell', $subject_settings->grade_cell) }}">
	</p>

	<p>
		<label for="cell_range">Cell Range</label>
		<input type="text" name="cell_range" id="cell_range" value="{{ old('cell_range', $subject_settings->cell_range) }}">
	</p>

	<p>
		<label for="header_row">Header Row</label>
		<input type="number" name="header_row" id="header_row" value="{{ old('header_row', $subject_settings->header_row) }}">
	</p>

	<p>
		<label for="start_row">Start Row</label>
		<input type="number" name="start_row" id="start_row" value="{{ old('start_row', $subject_settings->start_row) }}">
	</p>

	<p>
		<label for="end_row">End Row</label>
		<input type="number" name="end_row" id="end_row" value="{{ old('end_row', $subject_settings->end_row) }}">
	</p>

	<button class="success next">Next</button>
</form>
@stop

@section('dropzone_script')
<script src="{{ url('assets/lib/dropzone/dropzone.min.js') }}"></script>
@stop

@section('uploads_script')
<script src="{{ url('assets/js/uploads.js') }}"></script>
@stop