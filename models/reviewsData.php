<?php
try {
  $bdd =new PDO('mysql:host=localhost;dbname=btelecom;charset=utf8', 'root', '');
}
catch(Exception $e){
  die('Erreur : '.$e->getMessage());
}
// A revoir pour récupérer les dates les plus récentes !!!
$reponse = $bdd->query('SELECT date_epoch, appID, review, stars, user_name FROM appstore_reviews where appID = "739824309" ORDER BY date_epoch Desc');
$reviewsarray = array();
while ($donnees = $reponse->fetch()){
  $reviewsarray[] = $donnees;
}

$fp = fopen('./tables/reviewsData.json', 'w'); //création du fichier
fwrite($fp, json_encode($reviewsarray));       //on écit les données dans le barometreData.json
fclose($fp);                                     //on ferme le barometreData.json

//fermer la connexion à la BDD
$reponse->closeCursor();
