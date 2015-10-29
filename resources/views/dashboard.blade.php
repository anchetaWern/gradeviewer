@extends('layouts.main')

@section('content')
<p>
What would you like to do?
</p>
<ul>
	<li>
		<a href="/subjects">View Grades</a>
	</li>
	<li>
		<a href="/subjects/new">Add Subject</a>
	</li>
</ul>
@stop