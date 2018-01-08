<?php

abstract class Person
{
  private $_id;
  private $_name;
  private $_first_name;
  private $_mail;
  private $_login;
  private $_password;
  private $_salt;
  
  public function __construct($name, $first_name, $mail, 
                                  $login, $password)
  {
    $this->_id = -1;
    $this->_name = $name;
    $this->_first_name = $first_name;
    $this->_mail = $mail;
    $this->_login = $login;
    $this->_password = $password;
  }
  
  public function getID()
  {
    return $this->_id;
  }
  
  public function setId($id)
  {
    $this->_id = $id;
  }

  public function getName()
  {
    return $this->_name;
  }
  
  public function getFirstName()
  {
    return $this->_first_name;
  }
  
  public function getMail()
  {
    return $this->_mail;
  }
  
  public function getLogin()
  {
    return $this->_login;
  }
  
  public function getPassword()
  {
    return $this->_password;
  }

  public function getSalt()
  {
    return $this->_salt;
  }

  public function setSalt($salt)
  {
    $this->_salt = $salt;
  }
}

class Administration extends Person
{
  private $_id_Administration;
  private $_fonction;
  private $_phone;
  private $_office;
  private $_schedules;
  
  public function __construct($name, 
                             $first_name, $mail, $login, $password, 
                             $fonction, $phone, $office, $schedules)
  {
    parent::__construct($name, $first_name, $mail, $login, 
                        $password);
    $this->_id_Administration = -1;
    $this->_fonction = $fonction;
    $this->_phone = $phone;
    $this->_office = $office;
    $this->_schedules = $schedules;
  }
  
  public function getIdAdministration()
  {
    return $this->_id_Administration;
  }
  
  public function getFonction()
  {
    return $this->_fonction;
  }
  
  public function getPhone()
  {
    return $this->_phone;
  }
  
  public function getOffice()
  {
    return $this->_office;
  }
  
  public function getSchedules()
  {
    return $this->_schedules;
  }
}

class Teacher extends Person
{
  private $_id;
  public function __construct($id, $name, $first_name, $mail, $login, 
                             $password)
  {
    parent::__construct($name, $first_name, $mail, $login, 
                       $password);
    $this->_id = $id;
  }
  
  public function getTeacherId()
  {
   return $this->_id;
  }
}

class Student extends Person
{
  private $_studentNumber;
  private $_department;
  private $_branch;
  private $_year;
  
  public function __construct($name, $first_name, $mail, $login, 
                             $password, $studentNumber, $department, 
                             $branch, $year)
  {
    parent::__construct($name, $first_name, $mail, $login, 
                       $password);
    $this->_studentNumber = $studentNumber;
    $this->_department = $department;
    $this->_branch = $branch;
    $this->_year = $year;
  }

  public function getStudentNumber()
  {
    return $this->_studentNumber;
  }

  public function getDepartment()
  {
    return $this->_department;
  }

  public function getBranch()
  {
    return $this->_branch;
  }

  public function getYear()
  {
    return $this->_year;
  }
}

class Message 
{
  private $_id;
  private $_id_Sender;
  private $_subject;
  private $_body;
  private $_date;
  
  public function __construct($idSender, $subject, $body, $date)
  {
    $this->_id = -1;
    $this->_id_Sender = $idSender;
    $this->_subject = $subject;
    $this->_body = $body;
    $this->_date = $date;
  }
  
  public function getId()
  {
    return $this->_id;
  }
  
  public function getIdSender()
  {
    return $this->_id_Sender;
  }
  
  public function getSubject()
  {
    return $this->_subject;
  }
  
  public function getBody()
  {
    return $this->_body;
  }
  
  public function getMessageDate()
  {
    return $this->_date;
  }
}

class Receiver
{
  private $_id_Message;
  private $_id_Person;
  private $_message_Read;
  private $_archived;
  private $_deleted;
  
  public function __construct($idMessage, $idPerson, $messageRead, 
                             $archived, $deleted)
  {
    $this->_id_Message = $idMessage;
    $this->_id_Person = $idPerson;
    $this->_message_Read = $messageRead;
    $this->_archived = $archived;
    $this->deleted = $deleted;
  }
  
  public function getIdMessage()
  {
    return $this->_id_Message;
  }
  
  public function getIdPerson()
  {
    return $this->_id_Person;
  }
  
  public function getMessageRead()
  {
    return $this->_message_Read;
  }
  
  public function getArchived()
  {
    return $this->_archived;
  }
  
  public function getDeleted()
  {
    return $this->_deleted;
  }
}

class Teaching_Unit
{ 
  private $_code;
  private $_name;
  private $_year;
  private $_branch;
  private $_department;
  private $_ects;
  
  public function __construct($code, $name, $year, $branch, $department, 
                             $ects)
  {
    $this->_code = $code;
    $this->_name = $name;
    $this->_year = $year;
    $this->_branch = $branch;
    $this->_department = $department;
    $this->_ects = $ects;
  }
  
  public function getCode()
  {
    return $this->_code;
  }
  
  public function getName()
  {
    return $this->_name;
  }
  
  public function getYear()
  {
    return $this->_year;
  }
  
  public function getBranch()
  {
   return $this->_branch; 
  }
  
  public function getDepartment()
  {
    return $this->_department;
  }
  
  public function getEcts()
  {
    return $this->_ects;
  }
}

class Alias
{
  private $_id;
  private $_name;
  private $_private;
  
  public function __construct($name, $private)
  {
    $this->_id = -1;
    $this->_name = $name;
    $this->_private = $private;
  }
  
  public function getId()
  {
    return $this->_id;
  }
  
  public function getName()
  {
    return $this->_name;
  }
  
  public function getPrivate()
  {
    return $this->_private;
  }
}

class Member_Alias
{
  private $_id_Alias;
  private $_id_Person;
  
  public function __construct($id_Alias, $id_Person)
  {
    $this->_id_Alias = $id_Alias;
    $this->_id_Person = $id_Person;
  }
  
  public function getIdAlias()
  {
    return $this->_id_Alias;
  }
  
  public function getIdPerson()
  {
   return $this->_id_Person; 
  }
}

class Course
{
  private $_code;
  private $_name;
  private $_code_TU;
  private $_coefficient;
  private $_threshold;
  private $_class_Hours;
  private $_TD_Hours;
  private $_TP_Hours;
  private $_project_Hours;
  private $_internship;
  
  public function __construct($code, $name, $code_TU, $coefficient, 
  $threshold,$class_Hours, $TD_Hours, $TP_Hours, $project_Hours, 
  $internship)
  {
    $this->_code = $code;
    $this->_name = $name;
    $this->_code_TU = $code_TU;
    $this->_coefficient = $coefficient;
    $this->_threshold = $threshold;
    $this->_class_Hours = $class_Hours;
    $this->_TD_Hours = $TD_Hours;
    $this->_TP_Hours = $TP_Hours;
    $this->_project_Hours = $project_Hours;
    $this->_internship = $internship;
  }
  
  public function getCode()
  {
    return $this->_code;
  }
  
  public function getName()
  {
    return $this->_name;
  }
  
  public function getCodeTU()
  {
    return $this->_code_TU;
  }
  
  public function getCoefficient()
  {
    return $this->_coefficient;
  }
  
  public function getThreshold()
  {
    return $this->_threshold;
  }
  
  public function getClassHours()
  {
    return $this->_class_Hours;
  }
  
  public function getTDHours()
  {
    return $this->_TD_Hours;
  }
  
  public function getTPHours()
  {
    return $this->_TP_Hours;
  }
  
  public function getProjectHours()
  {
    return $this->_project_Hours;
  }
  
  public function getInternship()
  {
    return $this->_internship;
  }
}

class Course_Description
{
  private $_code_Course;
  private $_id_Teacher;
  private $_prerequisites;
  private $_content;
  private $_equipment;
  private $_evaluation;
  private $_bibliography;
  
  public function __construct($codeCourse, $idTeacher, $prerequisites, 
    $content, $equipment, $evaluation, $bibliography)
  {
      $this->_code_Course = $codeCourse;
      $this->_id_Teacher = $idTeacher;
      $this->_prerequisites = $prerequisites;
      $this->_content = $content;
      $this->_equipment = $equipment;
      $this->_evaluation = $evauluation;
      $this->_bibliography = $bibliography;
  }
    
  public function getCodeCourse()
  {
    return $this->_code_Course;
  }
  
  public function getIdTeacher()
  {
    return $this->_id_Teacher;
  }
  
  public function getPrerequisites()
  {
    return $this->_prerequisites;
  }
  
  public function getContent()
  {
    return $this->_content;
  }
  
  public function getEquipment()
  {
    return $this->_equipment;
  }
  
  public function getEvaluation()
  {
    return $this->_evaluation;
  }
  
  public function getBibliography()
  {
    return $this->_bibliography;
  }
}
?>
