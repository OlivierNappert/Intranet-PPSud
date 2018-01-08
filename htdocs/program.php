<?php 
  if(isset($_POST['password']) && isset($_POST['confirm']) && isset($_SESSION['id']))
  {
    $password = htmlspecialchars($_POST['password']);
    $confirm = htmlspecialchars($_POST['confirm']);
    if(strcmp($password, $confirm))
    {
      echo '<script language="javascript">';
      echo 'alert("Les mots de passe saisis ne sont pas identiques")';
      echo '</script>';
    }
    else if(strlen($password) < 5)
    {
      echo '<script language="javascript">';
      echo 'alert("Le mot de passe saisi est trop court")';
      echo '</script>';
    }
    else
      $bdd->changePassword($_SESSION['id'], $password);
  }
?>

<!DOCTYPE html>
<html>
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
      include('navigation.php');
    ?>
    <div class="container">    
<div class="jumbotron" style="background-color: white;">
  <div class="row">
    <div class="col-md-8 col-xs-12 col-sm-6 col-lg-8">
      <ul class="container details">
  <?php
    $TU = $bdd->getTU($_POST['year'], $_POST['branch'], $_POST['department']);
    $courses = $bdd->getCourses($_POST['year'], $_POST['branch'], $_POST['department']);

    ?>
    <style>
    .program{
      border-collapse: collapse;
      border-style: solid;
      border-width: 1px;
      border-color: black;
    }

    .program td, .program th{
      border-style: solid;
      border-width: 1px;
      border-color: black;
      padding: 3px;
      text-align: center;
    }

    .total{
      background-color: black;
      color: white;
      font-style: bold;
    }

    .TU{
      background-color: red;
      color: white;
      font-style: bold;
    }
    </style>
    <table class="program">
      <tr>
        <th>Code</th>
        <th>Titre</th>
        <th>ECTS</th>
        <th>Coeff</th>
        <th>Seuil</th>
        <th>Cours</th>
        <th>TD</th>
        <th>TP</th>
        <th>Projet</th>
        <th>Total</th>
        <th>Stage</th>
      </tr>

    <?php
    $total = array(
      'ECTS' => 0,
      'Coeff' => 0,
      'Seuil' => 10,
      'Cours' => 0,
      'TD' => 0,
      'TP' => 0,
      'Projet' => 0,
      'Stage' => 0,
    );

    foreach($TU as $t){
      $total['ECTS'] += $t['ects'];
    }

    foreach($courses as $c){
      $total['Coeff'] += $c['coefficient'];
      $total['Cours'] += $c['class_Hours'];
      $total['TD'] += $c['TD_Hours'];
      $total['TP'] += $c['TP_Hours'];
      $total['Projet'] += $c['project_Hours'];
      $total['Stage'] += $c['internship'];
    }
    ?>
      <tr>
        <td class="total"></td>
        <td class="total"></td>
        <td class="total"><?php echo $total['ECTS']; ?></td>
        <td class="total"><?php echo $total['Coeff']; ?></td>
        <td class="total"><?php echo $total['Seuil']; ?></td>
        <td class="total"><?php echo $total['Cours']; ?></td>
        <td class="total"><?php echo $total['TD']; ?></td>
        <td class="total"><?php echo $total['TP']; ?></td>
        <td class="total"><?php echo $total['Projet']; ?></td>
        <td class="total"><?php echo ($total['Cours']+$total['TD']+$total['TP']+$total['Projet']); ?></td>
        <td class="total"><?php echo $total['Stage']; ?></td>
      </tr>
    <?php
    foreach($TU as $t){
      foreach($total as $k => $v){
        $total[$k] = 0;
      }
      $total['Seuil'] = 10;

      foreach($courses as $c){
        if($c['code_TU'] == $t['code']){
          $total['Coeff'] += $c['coefficient'];
          $total['Cours'] += $c['class_Hours'];
          $total['TD'] += $c['TD_Hours'];
          $total['TP'] += $c['TP_Hours'];
          $total['Projet'] += $c['project_Hours'];
          $total['Stage'] += $c['internship'];
        }
      }
    ?>
      <tr>
        <th class="TU">UE : <?php echo $t['code']; ?></th>
        <th class="TU"><?php echo $t['name']; ?></th>
        <th class="TU"><?php echo $t['ects']; ?></th>
        <th class="TU"><?php echo $total['Coeff']; ?></th>
        <th class="TU"><?php echo $total['Seuil']; ?></th>
        <th class="TU"><?php echo $total['Cours']; ?></th>
        <th class="TU"><?php echo $total['TD']; ?></th>
        <th class="TU"><?php echo $total['TP']; ?></th>
        <th class="TU"><?php echo $total['Projet']; ?></th>
        <th class="TU"><?php echo ($total['Cours']+$total['TD']+$total['TP']+$total['Projet']); ?></th>
        <th class="TU"><?php echo $total['Stage']; ?></th>
      </tr>
    <?php
      foreach($courses as $c){
        if($c['code_TU'] == $t['code']){
          ?>
          <tr>
            <td><?php echo $c['code']; ?></td>
            <td><?php echo $c['name']; ?></td>
            <td></td>
            <td><?php echo $c['coefficient']; ?></td>
            <td></td>
            <td><?php echo $c['class_Hours']; ?></td>
            <td><?php echo $c['TD_Hours']; ?></td>
            <td><?php echo $c['TP_Hours']; ?></td>
            <td><?php echo $c['project_Hours']; ?></td>
            <td><?php echo ($c['class_Hours']+$c['TD_Hours']+$c['TP_Hours']+$c['project_Hours']); ?></td>
            <td><?php echo $c['internship']; ?></td>
          </tr>
    <?php
        }
      }
    }
    ?>

    </table>
    <p>Les durées sont exprimées en heures, sauf le stage en semaine.<br/>Le volume des projets correspond au volume d'heures encadrées.</p>
      </ul>
    </div>
  </div>
      </div>
    </div>  
  </div>
</body>
<?php include('footer.php');?>
</html>
