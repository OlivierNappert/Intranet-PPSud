<?php
require_once('dataClasses.php');

class Bdd
{
  private $_bdd;
  
  public function __construct()
  {
    try
    {
      $this->_bdd = new PDO('mysql:host=localhost;dbname=intranet;charset=utf8', 'root', 'root');
    }
    catch (Exception $e)
    {
      die('Erreur : ' . $e->getMessage());
    }

    // Affiche les erreurs lors des requetes sur la base de données
    $this->_bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $this->_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
   
  // Ajouts dans la base de données

  public function newCourse(Course $c)
  {
   $req = $this->_bdd->prepare('INSERT INTO course(name, code_TU, coefficient, 
      threshold, class_Hours, TD_Hours, TP_Hours, project_Hours, 
      internship) 
      VALUES(:name, :code_TU, :coefficient, :threshold, :class_Hours, 
      :TD_Hours, :TP_Hours, :project_Hours, :internship)');

    $req->bindValue(':name', $c->getName(), PDO::PARAM_STR);
    $req->bindValue(':code_TU', $c->getCodeTU(), PDO::PARAM_STR);
    $req->bindValue(':coefficient', $c->getCoefficient(), PDO::PARAM_INT);
    $req->bindValue(':threshold', $c->getThreshold(), PDO::PARAM_INT);
    $req->bindValue(':class_hours', $c->getClassHours(), PDO::PARAM_INT);
    $req->bindValue(':TD_Hours', $c->getTDHours(), PDO::PARAM_INT);
    $req->bindValue(':TP_Hours', $c->getTPHours(), PDO::PARAM_INT);
    $req->bindValue(':project_Hours', $c->getProjectHours(), PDO::PARAM_INT);
    $req->bindValue(':internship', $c->getInternship(), PDO::PARAM_INT);

    $req->execute();
  }

  public function generateSalt($length)
  {
    $trueCrypt = true;
    $salt = openssl_random_pseudo_bytes($length, $trueCrypt);

    return $salt;
  }


  public function hashPassword($password, $salt)
  {
    $options = [
      'cost' => 16,
      'salt' => $salt,
    ];

    $hash = password_hash($password, PASSWORD_BCRYPT, $options);

    return $hash;
  }

  public function newPerson(Person $p)
  {
    $saltLength = 60;//60 est la longueur du hash genere par bcrypt
    $p->setSalt($this->generateSalt($saltLength));

    $req = $this->_bdd->prepare('INSERT INTO person(name, first_name, mail, login,
      password, salt)
      VALUES(:name, :first_name, :mail, :login, :password, :salt)');

    $req->bindValue(':name', $p->getName(), PDO::PARAM_STR);
    $req->bindValue(':first_name', $p->getFirstName(), PDO::PARAM_STR);
    $req->bindValue(':mail', $p->getMail(), PDO::PARAM_STR);
    $req->bindValue(':login', $p->getLogin(), PDO::PARAM_STR);
    $req->bindValue(':password', $this->hashPassword($p->getPassword(), $p->getSalt()),
      PDO::PARAM_STR);
    $req->bindValue(':salt', $p->getSalt(), PDO::PARAM_STR);

    $req->execute();
  }
    
  public function newAdministration(Administration $a)
  {
    $req = $this->_bdd->prepare('INSERT INTO administration(fonction, phone, office,
      schedules, id_Person)
      VALUES(:fonction, :phone, :office, :schedules, :id_Person)');

    $req->bindValue(':fonction', $a->getFonction(), PDO::PARAM_STR);
    $req->bindValue(':phone', $a->getPhone(), PDO::PARAM_STR);
    $req->bindValue(':office', $a->getOffice(), PDO::PARAM_STR);
    $req->bindValue(':schedules', $a->getSchedules, PDO::PARAM_STR);
    $req->bindValue(':id_Person', $this->newPerson($a), PDO::PARAM_INT);

    $req->execute();
  }
  
  public function newTeacher(Teacher $t)
  {
    $req = $this->_bdd->prepare('INSERT INTO teacher(id_Person)
      VALUES(:id_Person)');

    $req->bindValue(':id_Person', $this->newPerson($t), PDO::PARAM_INT);

    $req->execute();
  }
  
  public function newStudent(Student $s)
  {
    $req = $this->_bdd->prepare('INSERT INTO student(id_Person, student_Number, 
      department, branch, year)
      VALUES(:id_Person, :studentNumber, :department, :branch, :year)');

    $req->bindValue(':id_Person', $this->newPerson($s), PDO::PARAM_INT);
    $req->bindValue(':studentNumber', $s->getStudentNumber(), PDO::PARAM_INT);
    $req->bindValue(':department', $s->getDepartment(), PDO::PARAM_STR);
    $req->bindValue(':branch', $s->getBranch(), PDO::PARAM_STR);
    $req->bindValue(':year', $s->getYear(), PDO::PARAM_INT);
    
    $req->execute();
  }
  
  public function newAlias(Alias $a)
  {
    $req = $this->_bdd->prepare('INSERT INTO alias(name, private)
      VALUES(:name,:private)');
    
    $req->bindValue(':name',$a->getName(), PDO::PARAM_STR);
    $req->bindValue(':private', $a->getPrivate(), PDO::PARAM_INT);
  }
  
  
  // Lectures dans la base de données

  public function getIdByLogin($login)
	{
		// On recupere l'id associe au login	  
		$reqID= $this->_bdd->prepare('SELECT ID
							FROM person
							WHERE login = :login');

		$reqID->bindValue(':login', $login, PDO::PARAM_STR);

		$reqID->execute();

		$Id = $reqID->fetch(PDO::FETCH_ASSOC);

		return $Id['ID'];
	}
  
  public function __destruct()
  {
    $this->_bdd = null;
  }

  /* Fonction qui recupere l'ensemble des messages non supprimes et non archives
    * d'un utilisateur. */
  public function getMessagesById($ID)
  {
    $req = $this->_bdd->prepare('SELECT
      m.id, m.title, m.date, m.id_Sender, r.message_Read 
      FROM message AS m, receiver AS r 
      WHERE  m.id = r.id_message 
        AND r.id_Person = :id
        AND r.deleted = 0
        AND r.archived = 0
      ORDER BY m.date DESC');

    $req->bindValue(':id', $ID, PDO::PARAM_INT);

    $req->execute();

    return $req->fetchall(PDO::FETCH_ASSOC);
  }

    /* Fonction qui recupere l'ensemble des messages archives d'un utilisateur. */
  public function getArchivedMessagesById($ID)
  {
    $req = $this->_bdd->prepare('SELECT
      m.id, m.title, m.body, m.date, m.id_Sender, r.message_Read 
      FROM message AS m, receiver AS r 
      WHERE  m.id = r.id_message 
        AND r.id_Person = :id
        AND r.deleted = 0
        AND r.archived = 1
      ORDER BY m.date DESC');

    $req->bindValue(':id', $ID, PDO::PARAM_INT);

    $req->execute();

    return $req->fetchall(PDO::FETCH_ASSOC);
  }

     /* Fonction qui recupere l'ensemble des messages envoyes par un utilisateur. */
  public function getSentMessagesById($ID)
  {
    $req = $this->_bdd->prepare('SELECT
    m.id, m.title, m.date, r.id_Person 
    FROM message AS m, receiver AS r
    WHERE m.id = r.id_message
      AND m.id_Sender = :id 
      AND r.deleted = 0
    ORDER BY m.date DESC');

    $req->bindValue(':id', $ID, PDO::PARAM_INT);

    $req->execute();

    return $req->fetchall(PDO::FETCH_ASSOC);
  }

    /* Fonction qui archive un message s'il ne l'est pas deja,
    et qui le de-archive sinon */
  public function archiveMessage($ID)
  {
    $req = $this->_bdd->prepare('SELECT 
    r.archived 
    FROM receiver AS r
    WHERE r.id_message = :id
      AND r.deleted = 0
    ');

    $req->bindValue(':id', $ID, PDO::PARAM_INT);
    $req->execute();

    $archived = $req->fetch(PDO::FETCH_ASSOC);

    if($archived["archived"] == 0){
      // update table message and receiver
      $req = $this->_bdd->prepare('UPDATE receiver as r
      SET r.archived = 1
      WHERE r.id_message = :id
      ');
    }
    else{
      $req = $this->_bdd->prepare('UPDATE receiver as r
      SET r.archived = 0
      WHERE r.id_message = :id
      ');
    }

    $req->bindValue(':id', $ID, PDO::PARAM_INT);
    $req->execute();    
  }

    /* Fonction qui supprime un message via son ID */
  public function deleteMessage($ID)
  {
    $req = $this->_bdd->prepare('UPDATE receiver as r
      SET r.deleted = 1
      WHERE r.id_message = :id
    ');

    $req->bindValue(':id', $ID, PDO::PARAM_INT);
    $req->execute();
  }

  /* Fonction qui recupere un message d'un utilisateur */
  public function getSingleMessage($id_Person,$IDMESSAGE)
  {
     $req = $this->_bdd->prepare('SELECT
      m.id, m.title, m.body, m.date, m.id_Sender, r.message_Read
      FROM message AS m, receiver AS r 
      WHERE  m.id = r.id_message
        AND m.id = :idMessage 
        AND r.id_Person = :id
        AND r.deleted = 0
      ');

    $req->bindValue(':id', $id_Person, PDO::PARAM_INT);
    $req->bindValue(':idMessage', $IDMESSAGE, PDO::PARAM_INT);
    $req->execute();

    return $req->fetchall(PDO::FETCH_ASSOC);
  }
  
  /* Fonction qui recupere un message envoyé d'un utilisateur */
  public function getSingleMessageSent($id_Person,$IDMESSAGE)
  {     
    $req = $this->_bdd->prepare('SELECT
    m.id, m.title, m.body, m.date, r.id_Person 
    FROM message AS m, receiver AS r
    WHERE m.id = r.id_message
      AND m.id_Sender = :id
      AND m.id = :idMessage 
      AND r.deleted = 0
      LIMIT 1');

    $req->bindValue(':id', $id_Person, PDO::PARAM_INT);
    $req->bindValue(':idMessage', $IDMESSAGE, PDO::PARAM_INT);
    $req->execute();

    return $req->fetchall(PDO::FETCH_ASSOC);
  }

    /* Fonction qui fait le lien entre une question (son type, son contenu) et un message */
  public function getQuestionsFromMessage($ID)
  {
    $req = $this->_bdd->prepare('SELECT
      q.id, q.name, q.type, q.content
      FROM question AS q
      WHERE  q.id_message = :id
      ');

    $req->bindValue(':id', $ID, PDO::PARAM_INT);
    $req->execute();

    return $req->fetchall(PDO::FETCH_ASSOC);
  }

    /* Fonction qui met le statut d'un message lu a 1 */
  public function setMessageRead($ID)
  {
     $req = $this->_bdd->prepare('UPDATE receiver SET
      message_Read = 1
      WHERE id_Message = :id');

    $req->bindValue(':id', $ID, PDO::PARAM_INT);
    $req->execute();
  }
  
    /* Fonction qui renvoie le nom et le prenom d'un utilisateur a partir de son ID */
    public function getNameFromId($ID)
    {
      $req = $this->_bdd->prepare('SELECT p.name, p.first_name
        FROM person as p
        WHERE p.id = :id
      ');

      $req->bindValue(':id', $ID, PDO::PARAM_INT);
      $req->execute();

      return $req->fetchall(PDO::FETCH_ASSOC);
    }

	  /* Renvoie true si le couple (login, password) passe en parametre existe
	 * false sinon */
	public function checkAuthentication($login, $password)
	{
	  //on recupere le hash associe au login
	  $req = $this->_bdd->prepare('SELECT password
							FROM person
							WHERE login = :login');
	  $req->bindValue(':login', $login, PDO::PARAM_STR);
	  $req->execute();
	  
	  $auth = $req->fetch(PDO::FETCH_ASSOC);

	  //on compare le password au hash stocke dans la bdd
	  if(password_verify($password, $auth['password']))
		return true;

	  return false;
	}
  
  public function getPersonneProfile($id)
  {
    $reqStudents = $this->_bdd->prepare('SELECT p.name, p.first_name, p.mail, s.student_number,s.department, s.branch, s.year
      FROM person as p, student as s
      WHERE p.id = :id AND p.id = s.id_Person;
    ');
	  $reqStudents->bindValue(':id', $id, PDO::PARAM_STR);
	  $reqStudents->execute();
    $result = $reqStudents->fetch(PDO::FETCH_ASSOC);
    if(count($result) > 1)
      return new Student($result['name'], $result['first_name'], $result['mail'],"" ,"" , $result['student_number'], $result['department'], $result['branch'], $result['year']);
      
    $reqAdministration = $this->_bdd->prepare('SELECT p.name, p.first_name, p.mail, a.fonction, a.phone, a.office, a.schedules
      FROM person as p, administration as a
      WHERE p.id = :id AND p.id = a.id_Person;
    ');
	  $reqAdministration->bindValue(':id', $id, PDO::PARAM_STR);
	  $reqAdministration->execute();
    $result = $reqAdministration->fetch(PDO::FETCH_ASSOC);
    if(count($result) > 1)
      return new Administration($result['name'], $result['first_name'], $result['mail'],"" ,"" , $result['fonction'], $result['phone'], $result['office'], $result['schedules']);
  
    $reqTeacher = $this->_bdd->prepare('SELECT p.name, p.first_name, p.mail
      FROM person as p, teacher as t
      WHERE p.id = :id AND p.id = t.id_Person;
    ');
	  $reqTeacher->bindValue(':id', $id, PDO::PARAM_STR);
	  $reqTeacher->execute();
    $result = $reqTeacher->fetch(PDO::FETCH_ASSOC);
    if(count($result) > 0)
      return new Teacher($id, $result['name'], $result['first_name'], $result['mail'],"" ,"");
    }
    
    
  /* Cherche un utilisateur à l'aide de son login */
  public function getPersonByLogin($login)
  {
    // Recherche dans la base d'utilisateurs
    $req = $this->_bdd->prepare('SELECT id, name, first_name, mail, login
      FROM person
      WHERE login = :login');
    $req->bindValue(':login', $login, PDO::PARAM_STR);
    $req->execute();

    $result = $req->fetch(PDO::FETCH_ASSOC);

    if($result == null)
      return null;

    return ['type' => 'person',
      'id' => $result['id'],
      'name' => $result['name'],
      'first_name' => $result['first_name'],
      'mail' => $result['mail'],
      'login' => $result['login']];
  }

  /* Cherche un alias à l'aide de son nom */
  public function getAliasByName($name)
  {
    // Recherche dans la base d'utilisateurs
    $req = $this->_bdd->prepare('SELECT id, name
      FROM alias
      WHERE name = :name');
    $req->bindValue(':name', $name, PDO::PARAM_STR);
    $req->execute();

    $result = $req->fetch(PDO::FETCH_ASSOC);

    if($result == null)
      return null;

    return ['type' => 'alias',
      'id' => $result['id'],
      'name' => $result['name']];
  }
  
  public function newMessage(Message $m)
  {
    $req = $this->_bdd->prepare('INSERT INTO message(id_Sender, title, body, date)
      VALUES(:id_Sender, :title, :body, :date)');

    $req->bindValue(':id_Sender', $m->getIdSender(), PDO::PARAM_INT);
    $req->bindValue(':title', $m->getSubject(), PDO::PARAM_STR);
    $req->bindValue(':body', $m->getBody(), PDO::PARAM_STR);
    $req->bindValue(':date', $m->getMessageDate(), PDO::PARAM_STR);
    $req->execute();
    
    $req2 = $this->_bdd->prepare('SELECT id FROM message ORDER BY id DESC LIMIT 1;');
    $req2->execute();
    
    return $req2->fetch()[0];
  }
  
  public function newQuestion($idMessage, $id, $name, $type, $content)
  {
    $req = $this->_bdd->prepare('INSERT INTO question(id_message, id, name, type, content)
      VALUES(:id_message, :id, :name, :type, :content)');
    $req->bindValue(':id_message', $idMessage, PDO::PARAM_INT);
    $req->bindValue(':id', $id, PDO::PARAM_INT);
    $req->bindValue(':name', $name, PDO::PARAM_STR);
    $req->bindValue(':type', $type, PDO::PARAM_INT);
    $req->bindValue(':content', $content, PDO::PARAM_STR);
    $req->execute();
  }
  
  public function newReceiver($idMessage, $idPerson)
  {
    $req = $this->_bdd->prepare('INSERT INTO receiver
      VALUES(:id_Message, :id_Person, 0, 0, 0)');
    $req->bindValue(':id_Message', $idMessage);
    $req->bindValue(':id_Person', $idPerson);
    $req->execute();
  }
  
  public function answerMessage($idMessage, $idPerson, $idQuestion, $answers)
  {
    $req = $this->_bdd->prepare('SELECT COUNT(*)
      FROM answer
      WHERE id_message = :id_message
      AND id_person = :id_person
      AND id_question = :id_question');

    $req->bindValue(':id_message', $idMessage, PDO::PARAM_INT);
    $req->bindValue(':id_person', $idPerson, PDO::PARAM_INT);
    $req->bindValue(':id_question', $idQuestion, PDO::PARAM_INT);

    $req->execute();
    $result = $req->fetchAll(PDO::FETCH_ASSOC);

    if(isset($result) && $result[0]["COUNT(*)"] == 0)
    {
      $req = $this->_bdd->prepare('INSERT INTO answer(id_message, id_person, id_question, answer)
      VALUES(:id_message, :id_person, :id_question, :answer)');

      $req->bindValue(':id_message', $idMessage, PDO::PARAM_INT);
      $req->bindValue(':id_person', $idPerson, PDO::PARAM_INT);
      $req->bindValue(':id_question', $idQuestion, PDO::PARAM_INT);
      $req->bindValue(':answer', $answers, PDO::PARAM_STR);
      $req->execute();
    }

    else if(isset($result) && $result[0]["COUNT(*)"] > 0)
    {
      $req = $this->_bdd->prepare('UPDATE answer
        SET answer = :answer
        WHERE id_message = :id_message
        AND id_person = :id_person
        AND id_question = :id_question
      '); 

      $req->bindValue(':id_message', $idMessage, PDO::PARAM_INT);
      $req->bindValue(':id_person', $idPerson, PDO::PARAM_INT);
      $req->bindValue(':id_question', $idQuestion, PDO::PARAM_INT);
      $req->bindValue(':answer', $answers, PDO::PARAM_STR);
      $req->execute();
    }
  }
  
  public function getAnswers($id_Message)
  {
    $answers = array(array());
    $req = $this->_bdd->prepare('SELECT id_question, id_person, answer
      FROM answer
      WHERE id_message = :id_message');
    $req->bindValue(':id_message', $id_Message, PDO::PARAM_INT);
    $req->execute();

    return $req->fetchAll(PDO::FETCH_ASSOC);
  }
  
  
  public function changePassword($id, $password)
  {
    $saltLength = 60;//60 est la longueur du hash genere par bcrypt
    $salt = $this->generateSalt($saltLength);

    $req = $this->_bdd->prepare('UPDATE person SET password = :password, salt = :salt
      WHERE id = :id');

    $req->bindValue(':password', $this->hashPassword($password, $salt), PDO::PARAM_STR);
    $req->bindValue(':salt', $salt, PDO::PARAM_STR);
    $req->bindValue(':id', $id, PDO::PARAM_STR);
    $req->execute();
    echo "test";
  }

  public function getTU($year, $branch, $department)
  {
    $req = $this->_bdd->prepare('SELECT *
                                 FROM teaching_unit
                                 WHERE year = :year
                                 AND branch = :branch
                                 AND department = :department');

    $req->bindValue(':year', $year, PDO::PARAM_INT);
    $req->bindValue(':branch', $branch, PDO::PARAM_STR);
    $req->bindValue(':department', $department, PDO::PARAM_STR);

    $req->execute();

    return $req->fetchall(PDO::FETCH_ASSOC);
  }

  public function getCourses($year, $branch, $department)
  {
    $req = $this->_bdd->prepare('SELECT *
                                 FROM course
                                 WHERE code_TU IN (SELECT code
                                                   FROM teaching_unit
                                                   WHERE year = :year
                                                   AND branch = :branch
                                                   AND department = :department)
                                ');

    $req->bindValue(':year', $year, PDO::PARAM_INT);
    $req->bindValue(':branch', $branch, PDO::PARAM_STR);
    $req->bindValue(':department', $department, PDO::PARAM_STR);

    $req->execute();

    return $req->fetchall(PDO::FETCH_ASSOC);
  }

  public function getReceiversNames($id)
  {
    $req = $this->_bdd->prepare('SELECT receiver.id_Person, person.name, person.first_name
                                 FROM receiver, person
                                 WHERE receiver.id_Message = :id
                                 AND receiver.id_Person = person.id');

    $req->bindValue(':id', $id, PDO::PARAM_INT);

    $req->execute();

    return $req->fetchall(PDO::FETCH_ASSOC);
  }
  
  public function getMembersOfAlias($id)
  {
    $req = $this->_bdd->prepare('SELECT id_Person FROM member_alias WHERE id_alias = :id');
    $req->bindValue(':id', $id, PDO::PARAM_INT);
    $req->execute();

    return $req->fetchall(PDO::FETCH_ASSOC);
  }
  
  public function checkExistenceAnswer()
  {
    
  }

  //retourne toutes les notes d'un etudiant, dans l'ordre chronologique inverse
  public function getMarksById($idStudent)
  {
    $req = $this->_bdd->prepare('SELECT *
                                 FROM marks
                                 WHERE ID_Student = :idStudent
                                 ORDER BY Date DESC');

    $req->bindValue(':idStudent', $idStudent, PDO::PARAM_STR);
    
    $req->execute();

    return $req->fetchall(PDO::FETCH_ASSOC);
  }

  //retourne la moyenne des notes en fonction de ID_Eval
  public function getAverageByIdEval($idEval)
  {
    $req = $this->_bdd->prepare('SELECT AVG(Score) AS avg
                                 FROM marks
                                 WHERE ID_Eval = :idEval');

    $req->bindValue(':idEval', $idEval, PDO::PARAM_INT);

    $req->execute();

    $res = $req->fetch(PDO::FETCH_ASSOC);

    return $res['avg'];
  }

  //retourne l'ecart-type des notes en fonction de ID_Eval
  public function getSDByIdEval($idEval)
  {
    $req = $this->_bdd->prepare('SELECT STDDEV(Score) AS sd
                                 FROM marks
                                 WHERE ID_Eval = :idEval');

    $req->bindValue(':idEval', $idEval, PDO::PARAM_INT);

    $req->execute();

    $res = $req->fetch(PDO::FETCH_ASSOC);

    return $res['sd'];
  }

  //retourne la description d'un evaluation en fonction de son ID
  public function getDescByIdEval($idEval)
  {
    $req = $this->_bdd->prepare('SELECT Description
                                 FROM eval
                                 WHERE ID = :idEval');

    $req->bindValue(':idEval', $idEval, PDO::PARAM_INT);

    $req->execute();

    $res = $req->fetch(PDO::FETCH_ASSOC);

    return $res['Description'];
  }

  //retourne le numero etudiant d'un student en fonction de son id de person
  //CETTE FONCTION NE VERIFIE PAS QUE LA PERSONNE DONT ON PASSE L'ID EST BIEN
  //UN ETUDIANT (verif a faire avant l'appel)
  public function getStudentNumberById($id)
  {
    $req = $this->_bdd->prepare('SELECT student_Number
                                 FROM student
                                 WHERE id_Person = :idPerson');

    $req->bindValue(':idPerson', $id, PDO::PARAM_INT);

    $req->execute();

    $res = $req->fetch(PDO::FETCH_ASSOC);

    return $res['student_Number'];
  }
}
?>
