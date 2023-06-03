<?php

namespace App\Controllers;
use App\Libraries\Wonde_API;
class Home extends BaseController
{ 
    public function __construct()
    {
      $this->wonde = new Wonde_API();
    }

    public function index()
    {
      // school details
      $school = $this->wonde->get_school();
      $data['school'] = $school;

      // employees
      $teachers = array();
      $employees = $this->wonde->get_employees(array('employment_details'), array('has_class'=>'1'));

      foreach ($employees as $employee) 
      {
        $is_current = $employee->employment_details->data->current;
        $is_teacher = $employee->employment_details->data->teaching_staff;
        if ($is_current && $is_teacher)
        {
          $teachers[] = $employee;
        }
      }
      // order by surname 
      array_multisort(array_column($teachers,'surname'),SORT_ASC,$teachers);
      $data['teachers'] = $teachers;
      return view('school_homepage',$data);
    }

    public function teacher_classes()
    {
      $request_payload = $this->get_request_payload();
      $teacher_id = ($request_payload['teacher_id']) ? $request_payload['teacher_id'] : FALSE;
      $teacher_mis_id = ($request_payload['teacher_mis_id']) ? $request_payload['teacher_mis_id'] : FALSE;
      if ( ! $teacher_id || ! $teacher_mis_id)
      {
        return $this->error(404,'Requires a Teacher id');
      }      

      $teacher = $this->wonde->get_employee($teacher_id,array('classes'),array('only_mis_ids'=>$teacher_mis_id));
      $data['teacher'] = $teacher;
      $data['classes'] = $teacher->classes->data;
      return view('class_list',$data);
    }

    public function students_in_class()
    {
      $request_payload = $this->get_request_payload();
      $class_id = ($request_payload['class_id']) ? $request_payload['class_id'] : FALSE;
      $class_mis_id = ($request_payload['class_mis_id']) ? $request_payload['class_mis_id'] : FALSE;
      if ( ! $class_id || ! $class_mis_id)
      {
        return $this->error(404,'Requires a Class ID');
      }    
      $class = $this->wonde->get_class($class_id,array('students','students.house'),array('only_mis_ids'=>$class_mis_id,'has_students'=>'1'));
      $data['class'] = $class;

      // order by surname 
      $students = $class->students->data;
      array_multisort(array_column($students,'surname'),SORT_ASC,$students);
      $data['students'] = $students;
      return view('student_list',$data);
    }

    public function lessons_for_class()
    {
      $request_payload = $this->get_request_payload();
      $class_id = ($request_payload['class_id']) ? $request_payload['class_id'] : FALSE;
      $class_mis_id = ($request_payload['class_mis_id']) ? $request_payload['class_mis_id'] : FALSE;
      if ( ! $class_id || ! $class_mis_id)
      {
        return $this->error(404,'Requires a Class ID');
      }   
      $class = $this->wonde->get_class($class_id,array('students','students.house'),array('only_mis_ids'=>$class_mis_id,'has_students'=>'1'));
      $data['class'] = $class;

      $lessons = $this->wonde->get_lessons_for_class($class_id);
      // order by date
      array_multisort(array_column($lessons, 'start_at'), SORT_ASC,$lessons);
      $data['lessons'] = $lessons;
      return view('lessons',$data);
    }

    private function error($code,$msg)
    {
      return view('custom_error',array('code'=>$code,'msg'=>$msg));
    }

    private function get_request_payload()
    {   
      $request_payload = $this->request->getPost();
      return $request_payload;
    }
}
