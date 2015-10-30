<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use DB;
use App\Models\Subject as Subject;
use App\Models\Setting as Setting;
use App\Models\Activity as Activity;

class HomeController extends BaseController {
    
    public function dashboard(){

    	return view('dashboard');
    }


    public function newSubject(Request $request){

    	$request->session()->flush();
    	return view('new_subject');
    }


    public function upload(Request $request){

    	$file = $request->file('file');
    	$file_name = str_random(10) . '.' . $file->getClientOriginalExtension();

    	$request->session()->push('uploads', $file_name);

    	$destination_path = realpath(__DIR__ . '/../../../uploads');
    	$file->move($destination_path, $file_name);

    	return 'ok';
    }


    public function saveSubject(Request $request, Subject $subject, Setting $setting){

    	$title = $request->input('title');

    	$subject->title = $title;
    	$subject->save();
    	$subject_id = $subject->id;

    	session(array('subject_id' => $subject_id));

		$sheet_number = $request->input('sheet_number');
		$name_cell = $request->input('name_cell');
		$grade_cell = $request->input('grade_cell');
		$cell_range = $request->input('cell_range');
		$header_row = $request->input('header_row');
		$start_row = $request->input('start_row');
		$end_row = $request->input('end_row');

		$setting->subject_id = $subject_id;
		$setting->lec_xlsx = session('uploads')[0];
		$setting->lab_xlsx = session('uploads')[1];
		$setting->sheet_number = $sheet_number;
		$setting->name_cell = $name_cell;
		$setting->grade_cell = $grade_cell;
		$setting->cell_range = $cell_range;
		$setting->header_row = $header_row;
		$setting->start_row = $start_row;
		$setting->end_row = $end_row;
		$setting->save();

		return redirect('activities/add');

    }


    public function addActivities(){

    	$page_data = array(
    		'types' => array(
    			'seatwork', 'quiz', 'assignment', 'research', 'exam'
    		)
    	);

    	return view('activities', $page_data);
    }


    public function saveActivities(Request $request){

    	$activities = $request->input('activities');
    	
    	$subject_id = session('subject_id');

		DB::table('activities')
			->where('subject_id', '=', $subject_id)
			->delete();

    	if(!empty($activities)){
	    	foreach($activities as $act){
				DB::table('activities')->insert(
				    array(
				    	'subject_id' => $subject_id,
				    	'title' => $act['title'],
				    	'component' => $act['component'],
				    	'cell' => $act['cell'],
				    	'activity_type' => $act['type']
				    )
				);
	    	}
    	}

    	return 'ok';
    }


    public function subjects(Subject $subject){

    	$subjects = $subject->get();

    	$page_data = array(
    		'subjects' => $subjects
    	);

    	return view('subjects', $page_data);
    }


    function loadGrades($sheet_number, $cell_range,  $lec_xlsx, $lab_xlsx = ''){

    	$grades = array();
    	
    	if(!empty(session('grades'))){
    		$grades = session('grades');	
    	}

    	$uploads = array();
    	$uploads[] = $lec_xlsx;
    	if(!empty($lab_xlsx)){
    		$uploads[] = $lab_xlsx;
    	}

    	$uploads_path = realpath(__DIR__ . '/../../../uploads');

    	if(empty($grades)){

	    	foreach($uploads as $upload){
	    		//error here
				$objPHPExcel = \PHPExcel_IOFactory::load($uploads_path . "/{$upload}");

				$objWorksheet = $objPHPExcel->getSheet($sheet_number); 

				$grades[] = $objWorksheet->rangeToArray(
			        $cell_range,     
			        null,        
			        true,       
			        true,        
			        true 
				);

			}

			session(array('grades' => $grades));
    	}

    	return $grades;
    }


    public function viewGrades($id, $index = null, Subject $subject, Setting $setting, Activity $activity, Request $request){

    	$page_data = array(
    		'subject_id' => $id,
    		'subject' => $subject->find($id),
    	);

		$subject_settings = $setting->where('subject_id', '=', $id)
			->first();

		$name_cell = $subject_settings->name_cell;
		$grade_cell = $subject_settings->grade_cell;
		$header_row = $subject_settings->header_row;
		$start_row = $subject_settings->start_row;
		$end_row = $subject_settings->end_row;
		$sheet_number = $subject_settings->sheet_number;
		$cell_range = $subject_settings->cell_range;
		$lec_xlsx = $subject_settings->lec_xlsx;
		$lab_xlsx = $subject_settings->lab_xlsx;

		$page_data['start_row'] = $start_row;
		$page_data['end_row'] = $end_row;

		$grades = $this->loadGrades($sheet_number, $cell_range, $lec_xlsx, $lab_xlsx);

    	if($request->has('name')){

    		$name = strtolower($request->input('name'));

			$lec = $grades[0];

			$filtered_lec = array_filter($lec, function($row) use ($name, $name_cell) {
				if(preg_match('/' . $name . '/', strtolower($row[$name_cell]))){
					return $row;
				}
			});
			
			if(!empty($filtered_lec)){
				$lec_key = key($filtered_lec);
				$filtered_lec = $filtered_lec[$lec_key];
			}

			$lab = $grades[1];
			$filtered_lab = array_filter($lab, function($row) use ($name, $name_cell) {
				if(preg_match('/' . $name . '/', strtolower($row[$name_cell]))){
					
					return $row;
				}
			});

			if(!empty($filtered_lab)){
				$lab_key = key($filtered_lab);
				$filtered_lab = $filtered_lab[$lab_key];
			}

			$index = $lec_key;

    	}

		if(!is_null($index)){
			$lec = $grades[0];
			$filtered_lec = $lec[$index];

			if(!empty($grades[1])){
				$lab = $grades[1];
				$filtered_lab = $lab[$index];
			}
		}

		if(!empty($filtered_lec)){
			
			$student_name = $filtered_lec[$name_cell];

			$page_data['student_name'] = $student_name;

			$page_data['lec_grades'] = array();

			$lec_activities = $activity->where('subject_id', '=', $id)
							->where('component', '=', 'lec')
							->get();

			foreach($lec_activities as $al){
				$cell = $al['cell'];

				$page_data['lec_grades'][] = $al['title'] . ' - ' . $filtered_lec[$cell]  . '/' . $lec[$header_row][$cell]; 
				
			}

			$page_data['lec_grade'] = $filtered_lec[$grade_cell];

			if(!empty($grades[1])){

				$lab_activities = $activity->where('subject_id', '=', $id)->where('component', '=', 'lab')
						->get();

				$page_data['lab_grades'] = array();

				foreach($lab_activities as $al){
					$cell = $al['cell'];
				
					$page_data['lab_grades'][] = $al['title'] . ' - ' . $filtered_lab[$cell] . '/' . $lab[$header_row][$cell]; 
				}

				$page_data['lab_grade'] = $filtered_lab[$grade_cell];
			}

			$page_data['has_result'] = true;
			$page_data['prev_index'] = $index -= 1;
			$page_data['next_index'] = $index += 2;
		}

    	return view('grades', $page_data);

    }


    public function viewSubject($id, Subject $subject, Setting $setting, Request $request){

    	$page_data = array(
    		'subject' => $subject->find($id),
    		'subject_settings' => $setting->where('subject_id', '=', $id)->first()
    	);
    	
    	$request->session()->flush();
    	return view('update_subject', $page_data);

    }


    public function updateSubject($id, Subject $subject, Setting $setting, Request $request){

		$title = $request->input('title');

		$sub = $subject->find($id);
    	$sub->title = $title;
    	$sub->save();

    	session(array('subject_id' => $id));

    	$old_setting = $setting->find($id);

    	$uploads_path = realpath(__DIR__ . '/../../../uploads');
    	if($request->session()->has('uploads')){		
	    	if($old_setting->lec_xlsx){
	    		unlink($uploads_path . '/' . $old_setting->lec_xlsx);
	    	}
	    	if($old_setting->lab_xlsx){
	    		unlink($uploads_path . '/' . $old_setting->lab_xlsx);
	    	}
    	}

		$sheet_number = $request->input('sheet_number');
		$name_cell = $request->input('name_cell');
		$grade_cell = $request->input('grade_cell');
		$cell_range = $request->input('cell_range');
		$header_row = $request->input('header_row');
		$start_row = $request->input('start_row');
		$end_row = $request->input('end_row');

		$new_setting = array(
			'sheet_number' => $sheet_number,
			'name_cell' => $name_cell,
			'grade_cell' => $grade_cell,
			'cell_range' => $cell_range,
			'header_row' => $header_row,
			'start_row' => $start_row,
			'end_row' => $end_row
		);

		if($request->session()->has('uploads')){
			$new_setting['lec_xlsx'] = session('uploads')[0];
			$new_setting['lab_xlsx'] = session('uploads')[1];
		}

		$setting = DB::table('settings')
			->where('subject_id', '=', $id)
			->update($new_setting);

		return redirect("activities/{$id}/add");

    }
}
