@extends('layouts.main')

@section('content')
<h2>{{ $subject->title }} Grades</h2>

<form method="POST" action="/subject/{{ $subject_id }}">
	<p>
		<label for="name">Name</label>
		<input type="text" name="name" id="name">
	</p>
	<p>
		<button class="next">Search</button>
	</p>
</form>

<div id="grade-container">	
@if(!empty($has_result))
<h3>{{ $student_name }}</h3>
<div id="button-container">
	@if($prev_index >= $start_row)
	<a href="/subject/{{ $subject_id }}/row/{{ $prev_index }}">Prev</a>
	@endif
	@if($next_index < $end_row)
	<a href="/subject/{{ $subject_id }}/row/{{ $next_index }}" class="next">Next</a>
	@endif
</div>
@if(!empty($lec_grade))
<p>
	Lec: <strong>{{ $lec_grade }}</strong>
</p>
@endif

@if(!empty($lab_grade))
<p>
	Lab: <strong>{{ $lab_grade }}</strong>
</p>
@endif

@if(!empty($lec_grades))
<h4>Lec Break Down</h4>
<ul>
	@foreach($lec_grades as $lg)
		<li>{{ $lg }}</li>
	@endforeach
</ul>
@endif

@if(!empty($lab_grades))
<h4>Lab Break Down</h4>
<ul>
	@foreach($lab_grades as $lg)
		<li>{{ $lg }}</li>
	@endforeach
</ul>
@endif

@endif
</div>

@stop
