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
      if(isset($_SESSION['id']) && isset($_GET['idMessage']) && htmlspecialchars($_GET['idMessage']) >= 0)
      {
        $i=0;
        while(isset($_POST["$i"]))
        {
          $bdd->answerMessage(htmlspecialchars($_GET['idMessage']), $_SESSION['id'], $i, $_POST[$i]);
          $i++;
        }
        header('Location: messages.php');
      }
  ?>
    <div class="col-sm-9">
    </div>


  <?php
    }
  ?>
  </div>
</body>
<?php include('footer.php');?>
</html>
