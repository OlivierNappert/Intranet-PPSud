<?php
  require_once('../bdd/bdd.php');

  if(isset($_GET['name']))
  {
    $bdd = new Bdd();

    $result = $bdd->getPersonByLogin($_GET['name']);

    if($result != null)
      echo json_encode($result);
    else
    {
      $result = $bdd->getAliasByName($_GET['name']);
      if($result != null)
        echo json_encode($result);
      else
        echo json_encode(null);
    }
  }
?>
