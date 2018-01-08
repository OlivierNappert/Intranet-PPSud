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
              <style>
                .marks{
                  border-collapse: collapse;
                  border-style: solid;
                  border-width: 1px;
                  border-color: black;
                }

                .marks td, .marks th{
                  border-style: solid;
                  border-width: 1px;
                  border-color: black;
                  padding: 3px;
                  text-align: center;
                }

                .title{
                  background-color: red;
                  color: white;
                  font-style: bold;
                }
              </style>
              <table class="marks">
                <tr>
                  <th class="title">Date</th>
                  <th class="title">Contrôle</th>
                  <th class="title">Note</th>
                  <th class="title">Commentaire</th>
                  <th class="title">Moyenne</th>
                  <th class="title">Ecart-type</th>
                </tr>

              <?php
                $marks = $bdd->getMarksById($_SESSION['idStudent']);

                foreach($marks as $m)
                {
                  ?>
                  <tr>
                    <td><?php echo substr($m['Date'], 0, 10); ?></td>
                    <td><?php echo $bdd->getDescByIdEval($m['ID_Eval']); ?></td>
                    <td><?php echo $m['Score']; ?></td>
                    <td><?php echo $m['Comment']; ?></td>
                    <td><?php echo $bdd->getAverageByIdEval($m['ID_Eval']); ?></td>
                    <td><?php echo $bdd->getSDByIdEval($m['ID_Eval']); ?></td>
                  </tr>
                  <?php
                }
              ?>
              </table>
              <p>Les dates sont au format AAAA-MM-JJ.</p>
             </ul>
          </div>
        </div>
      </div>
    </div>  
  </div>
</body>
<?php include('footer.php');?>
</html>
