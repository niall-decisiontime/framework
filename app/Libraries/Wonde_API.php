<?php namespace App\Libraries;

class Wonde_API
{
  private $base_url;
  private $api_token;
  private $school_id;
  private $school;
  private $client;

  public function __construct()
  {
    $this->base_url = 'https://api.wonde.com/v1.0';
    $this->api_token = '2302e6c82cb36c3ad619d9372b9f6808ba2a560c'; ///needs to move to env variable
    $this->school_id = 'A1930499544'; 
    $this->client = new \Wonde\Client($this->api_token);
    $this->school = $this->client->school($this->school_id);

    $auth = $this->authentication();
    if ($auth->code != 200)
    {
      echo "ERROR: ".$auth->msg;
      die();
    }
  }

  public function get_school()
  {
    $school = $this->client->schools->get($this->school_id);
    return $school; 
  }

  public function get_student($student_id,$includes=array(),$params=array())
  {
    $student = $this->school->students->get($student_id,$includes,$params);
    return $student;
  }

  public function get_employee($employee_id,$includes=array(),$params=array())
  {
    $employee = $this->school->employees->get($employee_id,$includes,$params);
    return $employee;
  }

  public function get_class($class_id,$includes=array(),$params=array())
  {
    $class = $this->school->classes->get($class_id,$includes,$params);
    return $class;
  }

  public function get_employees($includes=array(), $params=array())
  {
    $employees = $this->school->employees->all($includes,$params);
    return $employees;
  }

  private function authentication()
  {
    try {
      // Initialize a cURL session
      $curl = curl_init();

      // Set cURL options
      curl_setopt($curl, CURLOPT_URL, $this->base_url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
      curl_setopt($curl, CURLOPT_HTTPHEADER, [
          'Authorization: Bearer ' . $this->api_token,
      ]);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);

      // Execute the cURL request
      $response = curl_exec($curl);
      $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
      $response = json_decode($response);

      if ($http_code != 200) 
      {
        curl_close($curl);
        if ($response->error)
        {
          return (object) array('code'=>$http_code,'msg'=>($response->error_description) ? $response->error_description : $response->error);
        }
        else 
        {
          throw new \Exception("ERROR: There has been an issue with this authentication. Please check your entries and try again.");
        }
      }
      else 
      {
        return (object) array('code'=>$http_code,'msg'=>'Success');
      }
    }
    catch (\Exception $e) 
    {
      return (object) array('code'=>403,'msg'=>$e->getMessage());
    }
  }
}