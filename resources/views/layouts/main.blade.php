<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Grade Viewer</title>
	<link rel="stylesheet" href="{{ url('assets/css/picnic.min.css') }}">
	<link rel="stylesheet" href="{{ url('assets/css/plugins.min.css') }}">
	
	@yield('sweetalert_style')

	@yield('dropzone_style')
	
	<link rel="stylesheet" href="{{ url('assets/css/style.css') }}">
</head>
<body>
	<div class="container">
		<header>		
			<img src="{{ url('assets/img/grade-viewer.png') }}" id="logo" alt="logo">
			<h1>Grade Viewer</h1>
		</header>
		@yield('content')
	</div>

	<script src="{{ url('assets/js/jquery.min.js') }}"></script>
	
	@yield('sweetalert_script')

	@yield('handlebars_script')

	@yield('activities_script')

	@yield('dropzone_script')
	@yield('uploads_script')
</body>
</html>