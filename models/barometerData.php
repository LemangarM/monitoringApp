<?php

try {
  $bdd =new PDO('mysql:host=localhost;dbname=btelecom;charset=utf8', 'root', '');
}
catch(Exception $e){
  die('Erreur : '.$e->getMessage());
}

if(isset($_POST['optionsRadios']) && $_POST['optionsRadios']=="00%"){

  $take_store=$_POST['optionsRadios'];

  // Google play Barometer
  $reponse = $bdd->query('SELECT appstore.appID, appName, DateMeasure, DateMeasureTaken, appTotalStars, image, store, sales_cumul.appID, Unites_cumul, Unites_total FROM sales_cumul LEFT JOIN appstore ON (appstore.appID=sales_cumul.appID) WHERE DateMeasure= (SELECT Max(DateMeasure) FROM sales_cumul) AND sales_cumul.appID LIKE "'.$take_store.'"');
}

elseif (isset($_POST['optionsRadios']) && $_POST['optionsRadios']!=="00%"){
  // App store Barometer
  $reponse = $bdd->query('SELECT appstore.appID, appName, DateMeasure, appTotalStars, image, store, sales_cumul.appID, Unites_cumul, Unites_total FROM sales_cumul LEFT JOIN appstore ON (appstore.appID=sales_cumul.appID) WHERE DateMeasure= (SELECT Max(DateMeasure) FROM sales_cumul) AND sales_cumul.appID NOT LIKE "00%"');
}

else {
  // Default Barometer (Google Play)
  $reponse = $bdd->query('SELECT appstore.appID, appName, DateMeasure, appTotalStars, image, store, sales_cumul.appID, Unites_cumul, Unites_total FROM sales_cumul LEFT JOIN appstore ON (appstore.appID=sales_cumul.appID) WHERE DateMeasure= (SELECT Max(DateMeasure) FROM sales_cumul) AND sales_cumul.appID ORDER BY appTotalStars DESC');
}

while ($donnees = $reponse->fetch()){
  $barometrearray[] = $donnees;
}


$fp = fopen('./tables/barometreData.json', 'w'); //création du fichier
fwrite($fp, json_encode($barometrearray));       //on écit les données dans le barometreData.json
fclose($fp);                                     //on ferme le barometreData.json

//fermer la connexion à la BDD
$reponse->closeCursor();
