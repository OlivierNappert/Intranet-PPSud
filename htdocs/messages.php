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
      <td colspan="3"><h2>Vos messages</h2></td>
      <td colspan="1.3" style="text-align:right;"><a href="messagesenvoyes.php">Messages envoyés</a></td>
      <td colspan="1.3"><a href="messagesarchives.php">Messages archivés</a></td>
      <td colspan="1.3"><a href="newmessage.php">Nouveau message</a></td>
    </tr>
    <tr>
      <td colspan="6"></td>
    </tr>
    <tr>
      <td>Date</td>
      <td>Expéditeur</td>
      <td colspan="2">Sujet</td>
      <td>Lu</td>
      <td>Actions</td>
    </tr>
  <?php
      $messages = $bdd->getMessagesById($_SESSION['id']);
      foreach($messages as $row){
        $name = $bdd->getNameFromId($row["id_Sender"]);
  ?>
        <tr>
          <td><?php echo $row["date"];?></td>
          <td><?php echo $name[0]["first_name"]." ".$name[0]["name"];?></td>
          <td colspan="2"><?php echo $row["title"];?></td>
          <td><?php echo $row["message_Read"] == 1 ? "Oui":"Non";?></td>
          <td>
            <a href="seeMessage.php?idMessage=<?php echo $row['id']?>">Voir le message</a> / 
              <a href="archiveMessage.php?id=<?php echo $row['id']?>">Archiver</a> / 
              <a href="deleteMessage.php?id=<?php echo $row['id']?>">Supprimer</a>
          </td>
        </tr>
  <?php
      }
  ?>
    </table>
    </div>
  <?php
    }
  ?>

  </div>
</body>
<?php include('footer.php');?>
</html>
