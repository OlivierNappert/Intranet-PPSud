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
      include('topnav.php'); 
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
      
      $person = $bdd->getPersonneProfile($_SESSION['id']);
      ?>
      <div class="container">    
        <div class="jumbotron" style="background-color: white;">
          <div class="row">
            <div class="col-md-offset-5">
              <img src="img/profile.png" alt="stack photo" class="img">
            </div>
            <div class="col-md-8 col-xs-12 col-sm-6 col-lg-8 ">
              <div class="col-md-8 col-xs-12 col-sm-6 col-lg-8 col-md-offset-6" style="border-bottom:1px solid black; text-align:center;">
                <?php
                  echo "<h2><b>" . $person->getFirstName() . " " . $person->getName() . " " . "</b></h2>"
                ?>
              </div>
              <hr>
              <ul class="col-md-8 col-xs-12 col-sm-6 col-lg-8 col-md-offset-6">
                <?php
                  if($person instanceof Student)
                  {
                    if(!isset($_SESSION['idStudent'])) $_SESSION['idStudent'] = $bdd->getStudentNumberById($_SESSION['id']);
                    echo "<li><p><span class=\"glyphicon glyphicon-envelope one\" style=\"width:50px;\"></span>" . $person->getMail() . "</p></li>";
                    echo "<li><p><span class=\"glyphicon glyphicon-book one\" style=\"width:50px;\"></span>". $person->getBranch() . $person->getYear() . "-". $person->getDepartment() ."</p></li>";
                    echo "<li><p><span class=\"glyphicon glyphicon-folder-open one\" style=\"width:50px;\"></span>". $person->getStudentNumber()."</p></li>";
                    echo "<li><p><span class=\"glyphicon glyphicon-pencil one\" style=\"width:50px;\"></span><input type=\"button\" onclick=\"location.href='marks.php'\" value=\"Notes\"></p></li>"; 
                  }
                  else if($person instanceof Administration)
                  {
                    echo "<li><p><span class=\"glyphicon glyphicon-envelope one\" style=\"width:50px;\"></span>" . $person->getMail() . "</p></li>";
                    echo "<li><p><span class=\"glyphicon glyphicon-tag one\" style=\"width:50px;\"></span>" . $person->getFonction(). "</p></li>";
                    echo "<li><p><span class=\"glyphicon glyphicon-earphone one\" style=\"width:50px;\"></span>" . $person->getPhone() . "</p></li>";
                    echo "<li><p><span class=\"glyphicon glyphicon-time one\" style=\"width:50px;\"></span>" . $person->getSchedules() . "</p></li>";
              
                  }
                  else if($person instanceof Teacher)
                  {
                    echo "<li><p><span class=\"glyphicon glyphicon-envelope one\" style=\"width:50px;\"></span>" . $person->getMail() . "</p></li>";
                  }
                ?> 
                <button type="button" class="btn btn-primary col-md-8 col-xs-12 col-sm-6 col-lg-8 col-md-offset-2" onclick = "changePass(this)"> <span class="glyphicon glyphicon-lock"></span> Changer mot de passe</button>
                <script type="text/javascript">
                  function changePass(button)
                  {
                    document.getElementById("changePassword").style= "visibility: visible";
                    button.style.visibility = "hidden";
                  }
                </script>
              </ul>
              <div id ="changePassword" class = "ol-md-8 col-xs-12 col-sm-6 col-lg-8 col-md-offset-6" style="visibility: hidden;">
                <div class="form-group">
                  <form action="user.php" method="post">
                  <label>Password</label>
                  <div class="input-group"> <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                      <input type="password" class="form-control" name="password" id="password" placeholder="Password" required data-toggle="popover" title="Password Strength" data-content="Enter Password...">
                  </div>
                </div>
                <div class="form-group">
                  <label>Confirm Password</label>
                  <div class="input-group"> <span class="input-group-addon"><span class="glyphicon glyphicon-resize-vertical"></span></span>
                    <input type="password" class="form-control" name="confirm" id="confirm" placeholder="Confirm Password" required>
                  </div>
                </div>
                <input type="submit"name="submit" id="submit" value="Submit" class="btn btn-primary pull-right">
                  </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php
      }
    ?>
  </div>
</body>
<?php include('footer.php');?>
</html>
