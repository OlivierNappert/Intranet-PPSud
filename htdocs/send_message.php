<?php 
  session_start();
  if(isset($_SESSION['id']))
  {
    include('../bdd/bdd.php');
    $bdd = new Bdd;
    if (isset($_POST['subject']) && isset($_POST['content']))
    {
      // Ajout dans la BDD des messages et on recupere l'id correspondant
      $id = $bdd->newMessage(new Message(htmlspecialchars($_SESSION['id']),htmlspecialchars($_POST['subject']), $_POST['content'], date ("Y-m-d H:i:s")));  
    }

    if(isset($_POST['recipients']))
    {
      // Ajout dans la BDD des personnes
      preg_match_all("/person_(\d+)[|]+/", htmlspecialchars($_POST['recipients']), $persons, PREG_SET_ORDER);
      foreach($persons as $receiver)
        $bdd->newReceiver($id, $receiver[1]);
        
      // Ajout dans la BDD des alias
      preg_match_all("/alias_(\d+)[|]+/", htmlspecialchars($_POST['recipients']), $alias, PREG_SET_ORDER);
      foreach($alias as $receiver)
      {
        foreach($bdd->getMembersOfAlias($receiver[1]) as $member)
        {
          $bdd->newReceiver($id, $member['id_Person']);
        }
      }
    }

    if(isset($_POST['questions']))
    {
      // Ajout dans la BDD des questions
      $a = 0;
      preg_match_all("/(\d)_([^{]*){([^}]*)}|/", htmlspecialchars($_POST['questions']), $matches, PREG_SET_ORDER);
      foreach($matches as $question)
      {
        if(count($question) > 1)
        {
          $bdd->newQuestion($id, $a, $question[2], $question[1], $question[3]);
          $a++;
        }
      }
    }
  }
?>
