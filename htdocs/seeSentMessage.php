
<!DOCTYPE html>
<html style="height: 100%;">

<head>
  <title>Intranet Polytech Paris-Sud</title>
  <meta charset="utf-8"/>
  <link href="bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script type="text/javascript" src="jquery-3.3.1/jquery.min.js"></script>
  <script type="text/javascript" src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
</head>

<body style="height:100%; background-color: #888888;">
<div class="container" style="min-height: 100%; background-color: white; padding: 0; height: auto;">
<?php 
  include_once('topnav.php');
  if(!(isset($_SESSION['id'])))
  {
?>
  <script type="text/javascript">
    alert("Erreur : vous n'êtes pas loggé. Redirection vers la page d'accueil.");
    location.href='index.php';
  </script>
<?php
  }
  else
  {
    include('navigation.php'); 
    $message = $bdd->getSingleMessageSent($_SESSION['id'],$_GET['idMessage']);
    $questions = $bdd->getQuestionsFromMessage($message[0]['id']);
    $receivers = $bdd->getReceiversNames($message[0]['id']);
?>
  <div class="col-sm-9">
  <h2>Contenu du message</h2>
  <table class="table">
  <tr>
  	<td colspan="1"><b>Titre</b></td>
  	<td colspan="5"><?php echo $message[0]["title"];?></td>
  </tr>
  <tr>
  	<td colspan="1"><b>Date</b></td>
  	<td colspan="2"><?php echo $message[0]["date"];?></td>
  	<td colspan="1"><b>Destinataires</b></td>
    <td colspan="2"><ul class="list-inline">
<?php foreach($receivers as $it)
{
  echo "<li>".$it['first_name']." ".$it["name"]."</li>";
} ?>
    </ul></td>
  </tr>
  <tr>
    <td colspan="6">
    <?php
      $text = nl2br($message[0]['body']);
      if(isset($questions) && isset($questions[0]))
      {
        foreach ($questions as $question)
        {
          $pattern = '/<'.$question["id"].'>/';
          $replacement = '<input type="text" placeholder="'.$question["name"].'" disabled/>';
          $text = preg_replace($pattern, $replacement, $text);
        }
      }
      echo $text;
    ?>
    </td>
  </tr>

<?php if(isset($questions) && isset($questions[0]))
      { ?>
</table>
<hr/>
<h2>Réponses aux questions</h2>
<?php
       $answers = $bdd->getAnswers($message[0]['id']);
       foreach($questions as $question)
       {
         echo '<hr/>';
         if($question['type'] == 0)
         {
           echo '<div class="row"><div class="col-sm-12"><h3 style="float: left; margin-top: 0">'
             .$question['name'].'</h3>
             <button class="btn btn-primary" type="button"
              data-toggle="collapse" data-target="#question'.$question['id']
              .'" style="float: right">Réponses individuelles</button></div>
              <div class="col-sm-12"><div class="collapse" id="question'
              .$question['id'].'"><div class="well">';
            foreach($answers as $answer)
            {
              if($answer['id_question'] == $question['id'])
              {
                foreach($receivers as $it)
                {
                  if($it['id_Person'] == $answer['id_person'])
                  {
                    $receiver = $it;
                    break;
                  }
                }
                echo $receiver['first_name'].' '.$receiver['name']
                  .' : '.$answer['answer'].'<br/>';
              }
            }
            echo '</div></div></div></div>';
          }
          else if($question['type'] == 1)
          {
            echo '<div class="row"><div class="col-sm-12">
              <h3 style="margin-top: 0">'.$question['name'].'</h3></div>';
            $possibleAnswers = explode(',', $question['content']);
            array_unshift($possibleAnswers, '# Aucun choix #');
            $totalAnswersCount = 0;
            foreach($answers as $answer)
            {
              if($answer['id_question'] == $question['id'])
                $totalAnswersCount++;
            }
            if($totalAnswersCount <= 0)
            {
              echo 'Il n\'y a eu aucune réponse pour le moment.';
            }
            else
            {
              foreach($possibleAnswers as $key => $possible)
              {
                $answersCount = 0;
                $personsList = '';
                foreach($answers as $answer)
                {
                  if($answer['id_question'] == $question['id']
                    && $answer['answer'] == $key)
                  {
                    $answersCount++;
                    foreach($receivers as $it)
                    {
                      if($it['id_Person'] == $answer['id_person'])
                      {
                        $receiver = $it;
                        break;
                      }
                    }
                    $personsList = '<li>'.$personsList.$receiver['first_name']
                      .' '.$receiver['name'].'</li>';
                  }
                }
                $percent = $answersCount*100/$totalAnswersCount;
                echo '
                  <div class="col-sm-12">
                  <div style="float: right"><button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#question'
                  .$question['id'].'_'.$key.'">'.$possible.'</button></div>
                  <div style="width: 100%"><div class="progress" style="height: 34px;">
                  <div class="progress-bar" valuemax="100" style="width: '
                  .$percent.'%; min-width: 2em; line-height: 35px">'.$percent.'%</div></div></div>';
                if($answersCount > 0)
                  echo '<div class="collapse" id="question'.$question['id'].'_'
                  .$key.'"><div class="well"><ul class="list-inline">'.$personsList
                  .'</ul></div></div>';
                echo '</div>';
              }
            }
            echo '</div>';
          }
        }
      }
    }
?>
</div>
</div>
</body>
</html>
