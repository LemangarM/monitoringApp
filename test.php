  <?php
function __autoload($class_name) {
    include $class_name . '.php';
}
       $donnees = \Models\Tables\Barometer::getBarometer();
      
       $fp = fopen('tables/test.json', 'w'); //création du fichier
       fwrite($fp, json_encode($donnees));       //on écit les données dans le barometreData.json
       fclose($fp);  
       
    
  


