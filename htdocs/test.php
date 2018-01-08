<?php require('../bdd/bdd.php');
$bdd = new Bdd();
$studentsArray = [
  new Student('Pillon', 'Fénéloffe', 'feneloffe.pillon@u-psud.fr',
    'admin', 'admin', '069', 'Informatique', 'ET', '4'),
  new Student('Prof', 'Jean', '@u-psud.fr',
    'teacher', 'teacher', '069', 'Informatique', 'ET', '4')];
foreach($studentsArray as $student)
{
  $bdd->newPerson($student);
}
?>
