
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
?>
  <div class="col-sm-9">
  <table class="table">
  <tr>
    <td colspan="3"><h2>Messages envoyés</h2></td>
    <td colspan="1"><a href="messagesarchives.php">Messages archivés</a></td>
    <td colspan="1"><a href="messages.php">Messages reçus</a></td>
    <td colspan="1"><a href="newmessage.php">Nouveau message</a></td>
  </tr>
   <tr>
    <td colspan="6"></td>
  </tr>
  <tr>
    <td>Date</td>
    <td colspan="2">Destinataire</td>
    <td colspan="2">Sujet</td>
    <td>Action</td>
  </tr>
<?php

    function idMessageNotSeen($id,$i,$messages)
    {
      $j = 0;
      foreach ($messages as $row){
        if($row["id"] == $id && $j < $i)
          return false;
        
        $j++;
      }
      return true;
    }

    $messages = $bdd->getSentMessagesById($_SESSION['id']);
    $i = 0;

    foreach($messages as $row)
    {
      $name = $bdd->getNameFromId($row["id_Person"]);
      $name = $name[0]["first_name"]." ".$name[0]["name"];
      if(isset($knownDest))
        unset($knownDest);

      $knownDest = array();
      array_push($knownDest,$name);

      if(idMessageNotSeen($row["id"],$i,$messages))
      {
        foreach($messages as $row2){
          if($row2["id"] == $row["id"])
          {
            $name2 = $bdd->getNameFromId($row2["id_Person"]);
            $name2 = $name2[0]["first_name"]." ".$name2[0]["name"];
            if(!in_array($name2, $knownDest))
            {
              array_push($knownDest,$name2);
            }
          }
        } 
?>
      <tr>
        <td><?php echo $row["date"];?></td>
        <td colspan="2"><?php echo implode(",",$knownDest);?></td>
        <td colspan="2"><?php echo $row["title"];?></td>
        <td>
          <a href="seeSentMessage.php?idMessage=<?php echo $row['id']?>">Voir le message</a> /  
            <a href="deleteMessage.php?id=<?php echo $row['id']?>">Supprimer</a>
        </td>
      </tr>
<?php
      }
      $i++;
      unset($name);
    }
?>
  </table>
  </div>


<?php
  }
?>

</div>
</body>
</html>
