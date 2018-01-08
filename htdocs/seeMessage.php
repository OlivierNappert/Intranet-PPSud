<!DOCTYPE html>
<html style="height: 100%;">
<head>
  <title>Intranet Polytech Paris-Sud</title>
  <meta charset="utf-8"/>
  <link href="bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script type="text/javascript" src="jquery-3.3.1/jquery.min.js"></script>
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
    $message = $bdd->getSingleMessage($_SESSION['id'],$_GET['idMessage']);
    $name = $bdd->getNameFromId($message[0]["id_Sender"]);
    $name = $name[0]["first_name"]." ".$name[0]["name"];
    $questions = $bdd->getQuestionsFromMessage($message[0]["id"]);

    if($message[0]["message_Read"] == 0)
    {
      $bdd->setMessageRead($message[0]["id"]);
    }
  ?>
    <div class="col-sm-9">
    <table class="table">
    <tr>
      <td colspan="1"><b>Titre</b></td>
      <td colspan="5"><?php echo $message[0]["title"];?></td>
    </tr>
    <tr>
      <td colspan="1"><b>Date</b></td>
      <td colspan="2"><?php echo $message[0]["date"];?></td>
      <td colspan="1"><b>Expéditeur</b></td>
      <td colspan="2"><?php echo $name;?></td>
    </tr>
    <tr>
      <td colspan="6">
      <?php
        if(isset($questions) && isset($questions[0]))
        {
          $message[0]["body"] = nl2br($message[0]["body"]);
          $page = 'answerMessage.php?idMessage='.$_GET["idMessage"];
          $message[0]["body"] = "<form action='".$page."' method='post'>" . $message[0]["body"];
          foreach ($questions as $question)
          {
            $pattern = '/<'.$question["id"].'>/';
            
            if($question["type"] == 0)
            {
              $replacement = '<input type="text" name="'.$question["id"].'" placeholder="'.$question["content"].'"/>';
              $message[0]["body"] = preg_replace($pattern, $replacement, $message[0]["body"]);
            }
            else if($question["type"] == 1)
            {
              $replacement = '<select name="'.$question["id"].'">';
              $options = explode(",",$question["content"]);
              $i = 0;
              $replacement .= '<option value="'.$i.'" selected="selected"></option>';
              foreach($options as $option)
              {
                $i++;
                $replacement .= '<option value="'.$i.'">'.$option.'</option>';
              }

              $replacement .= '</select><br/>';
              $message[0]["body"] = preg_replace($pattern, $replacement, $message[0]["body"]);
            }
          }
          $message[0]["body"] .= '<br/><br/><input type="submit" value="Répondre aux questions"/></form>';
        }
        echo nl2br($message[0]["body"]);
      ?>
      </td>
    </tr>
    </table>
    </div>
  <?php
      }
  ?>
  </div>
</body>
</html>
