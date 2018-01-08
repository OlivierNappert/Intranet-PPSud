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
  .event{
    text-align: center;
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
            <img src="img/soutenance.png" alt="stack photo" class="img">
<!--
          </div>
          <div class="col-md-8 col-xs-12 col-sm-6 col-lg-8 ">
            <div class="col-md-offset-7" style="text-align:center;">
-->
              <h2 class="event">Evenement de la semaine :</h2>
              <p class="event">Soutenance de projet<br/>Groupe : MoinsTuDorsPlusTesFort<br/>Sujet : Tableau de bord de l'étudiant</p>
            </div>
            <div class="col-md-offset-3">
            <iframe frameborder="0" height="600" scrolling="no" src="https://calendar.google.com/calendar/embed?showTitle=0&amp;showPrint=0&amp;showCalendars=0&amp;showTz=0&amp;mode=WEEK&amp;height=600&amp;wkst=2&amp;bgcolor=%23FFFFFF&amp;src=polytechpspops%40gmail.com&amp;color=%23853104&amp;src=tlpoao9qmpfepgbbpsgjfnnoe8%40group.calendar.google.com&amp;color=%23B1365F&amp;src=ljlsrnknj4t0ets8dqf70o3g4s%40group.calendar.google.com&amp;color=%23182C57&amp;ctz=Europe%2FParis" style="border-width: 0px" width="800"></iframe>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<?php include('footer.php');?>
</html>
