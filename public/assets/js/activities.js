var activities = [];
var activities_template = Handlebars.compile($('#activities-template').html());

function updateActivities(activities){
	var activities_html = activities_template({'activities': activities});
	$('#activities').html(activities_html);
}

$('#add').click(function(){

	var title = $('#title').val();
	var component = $('input[name=component]:checked').val();
	var cell = $('#cell').val();
	var type = $('#type').val();

	activities.push({
		'title': title,
		'component': component,
		'cell': cell,
		'type': type
	});

	updateActivities(activities);

	$('input[type=text]').val('');
});

$('#activities').on('click', '.delete', function(){
	var index = $(this).data('index');
	activities.splice(index, 1);

	updateActivities(activities);
});

$('#activities').on('click', '#done', function(){
	
	$.post(
		'/activities/save',
		{
			'activities': activities
		},
		function(response){
			if(response == 'ok'){
				swal("Awesome!", "Subject was added!", "success");
			}
		}
	);
});