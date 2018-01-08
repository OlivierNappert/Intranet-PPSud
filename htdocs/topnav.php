<?php
	session_start();
	include('../bdd/bdd.php');
	$bdd = new Bdd;
	// S'il s'agit d'une connexion
	if(isset($_POST['username']) AND isset($_POST['password']))
	{				
		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['password']);
		if ($bdd->checkAuthentication($username, $password))
		{
				$_SESSION['id'] = $bdd->getIdByLogin($username);
				$_SESSION['username'] = $username;
				$_SESSION['expired'] = time() + (5*60);
		}
	$bdd = null;
	}
?>
<nav class="navbar navbar-default" role="navigation">
  <!-- Ajout des logos--> 
  <div id="bs-example-navbar-collapse-1">
      <a class="navbar-brand" style="padding:10px;cursor: pointer; cursor: hand;" onclick="toIndex();"><img alt="Logo Polytech Paris-Sud" src="img/pps.jpg"></a>
      <a class="navbar-brand collapse navbar-collapse" style="padding:8px;cursor: pointer; cursor: hand; margin-left:10px;" onclick="toIndex();"><img alt="Logo Université Paris-Saclay" src="img/ups.jpg"></a>
    <!-- Ajout de la barre de recherche --> 
    <div class="col-md-3 collapse navbar-collapse">
        <form class="navbar-form" role="search">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="" name="s">
            <div class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
            </div>
        </div>
        </form>
    </div>
    <!-- Si l'utilisateur est connecté --> 
    <?php
      if(isset($_SESSION['username']) && isset($_SESSION['id']))
      {
    ?>
      <form class="navbar-form navbar-right">
        <div class="form-group collapse ">
          <?php echo $_SESSION['username']."&nbsp&nbsp";?>
        </div>
        <button type="submit" class="btn btn-default" onclick="toUser(); return false;"><span class="glyphicon glyphicon-user"></span></button>
        <button type="submit" class="btn btn-default" onclick="toMessage(); return false;"><span class="glyphicon glyphicon-envelope"></span></button>
        <button type="submit" class="btn btn-default" onclick="disconnect(); return false;"><span class="glyphicon glyphicon-off"></span></button>
      </form>
    <?php
      }
      else
      {
    ?>
      <!-- Sinon s'il n'est pas loggé -->
      <form class="navbar-form navbar-right" method = "post" action=" 
				<?php
					echo basename($_SERVER['PHP_SELF']); 
				?>
			">
          <input type="text" class="form-control" id="username" name="username"  placeholder="Utilisateur">
          <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe">
          <button type="submit" class="btn btn-default" id="login"><span class="glyphicon glyphicon-ok"></span></button>
      </form>
    <?php  
      }
    ?>
  </div>
</nav>

<script type="text/javascript">
function toUser()
{
  location.href='user.php';
}

function toMessage()
{
  location.href='messages.php';
}

function toIndex()
{
  location.href='index.php';
}

function disconnect()
{
  location.href='disconnect.php';
}
</script>
