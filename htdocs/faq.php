<!DOCTYPE html>
<?php
date_default_timezone_set('Europe/Paris');
?>
<html style="height: 100%;">
<head>
  <title>Intranet Polytech Paris-Sud</title>
  <meta charset="utf-8"/>
  <link href="bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script type="text/javascript" src="jquery-3.3.1/jquery.min.js"></script>
</head>

<style>
  .question{
    font-style: italic;
    color: blue;
    font-weight: bold;
  }

  .answer{
    color: black;
  }
</style>

<body style="height:100%; background-color: #888888;">
  <div class="container" style="min-height: 100%; background-color: white; padding: 0; height: auto;">

    <?php 
      include_once('topnav.php');
      include('navigation.php'); 
      ?>
    <div class="container">    
      <div class="jumbotron" style="background-color: white;">
        <div class="row">
          <div class="col-md-offset-3">
            <p class="question">Quelle est l'adresse de l'école ?</p>
            <p class="answer"><span class="glyphicon glyphicon-asterisk one" width="50px"></span>Bâtiment 620, Maison de l'Ingénieur, Rue Louis de Broglie, 91190 Orsay.</p>
            <p class="question">Comment joindre l'école ?</p>
            <p class="answer"><span class="glyphicon glyphicon-asterisk one" width="50px"></span>01 69 33 86 00</p>
            <p class="question">Comment se rendre à l'école ?</p>
            <p class="answer"><span class="glyphicon glyphicon-asterisk one" width="50px"></span>RER ligne B arrêt Le Guichet puis ligne de bus 9 jusqu'à l'arrêt Moulon.<br/><span class="glyphicon glyphicon-asterisk one" width="50px"></span>RER ligne B jusqu'à Orsay Ville puis ligne de bus 7 jusqu'à IUT - Maison de l'ingénieur.</p>
            <p class="question">Où se restorer à l'école ?</p>
            <p class="answer"><span class="glyphicon glyphicon-asterisk one" width="50px"></span>A la KFet, cafétéria gérée par les étudiants, à la MDI même.<br/><span class="glyphicon glyphicon-asterisk one" width="50px"></span>Dans les cafétérias et restaurants universitaires qui entourent l'école et ne sont pas plus distant que d'environ 5 minutes de marche. (IUT, PUIO, Supelec, Lieu de vie)</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<?php include('footer.php');?>
</html>
