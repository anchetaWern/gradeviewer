@extends('layouts.main')

@section('content')
<h3>Subjects</h3>
<table>
	<thead>
		<tr>
			<th>Subject</th>
			<th>Update</th>
			<th>View Grades</th>
		</tr>
	</thead>
	<tbody>
	@foreach($subjects as $subject)
		<tr>
			<td>{{ $subject->title }}</td>
			<td><a href="/subject/{{ $subject->id }}/update">update</a></td>
			<td><a href="/subject/{{ $subject->id }}">view</a></td>
		</tr>
	@endforeach
	</tbody>
</table>
@stop
