<?php

session_start();// À placer obligatoirement avant tout code HTML.

try
{
  // On se connecte à MySQL
  $bdd = new PDO('mysql:host=localhost;dbname=btelecom;charset=utf8', 'root', '');
}
catch(Exception $e)
{
  // En cas d'erreur, on affiche un message et on arrête tout
  die('Erreur : '.$e->getMessage());
}

// Si tout va bien, on peut continuer

// On récupère tout le contenu de la table jeux_video

//SELECT review FROM `appstore_reviews` WHERE 1
$reponse = $bdd->query('SELECT login, password FROM `users` WHERE 1');
// On affiche chaque entrée une à une
$i = 0;
$users = array();
while($donnees = $reponse->fetch())
{
  $users[$i]= array(0=>$donnees[0],1=>$donnees[1]);
  $i += 1;
}

$_SESSION['connect'] = 0; //Initialise la variable 'connect'.
if (isset($_POST['password']) AND isset($_POST['email'])) // Si les variables existent.
{
  $mot_de_passe=$_POST['password'];
  $login=$_POST['email'];

  $myUser = array(0=>$login,1=>$mot_de_passe);
  if(in_array($myUser, $users)){

    $_SESSION['connect']=1; // Change la valeur de la variable connect. C'est elle qui nous permettra de savoir s'il y a eu identification.
    $_SESSION['login']=$login;// Permet de récupérer le login afin de personnaliser la navigation.
  }
  echo $_SESSION['connect'];

}

else // Les variables n'existent pas encore.
{
  $mot_de_passe="";
  $login="";// On crée des variables $mot_de_passe  et $login vides.
}



if ($_SESSION['connect']==1)
{
  header('Location: index.php');

}
else // Le mot de passe n'est pas bon.
{
  // On affiche la zone de texte pour rentrer le mot de passe.
  ?>

  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forms</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/datepicker3.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->

  </head>

  <body>

    <div class="row">
      <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
          <div style="text-align: center;"><img src="images/logo.jpg" style="height: 200px;"/></div>
          <div class="panel-body">
            <form action="login.php" method="post">
              <fieldset style="text-align: center;">
                <div class="form-group">
                  <input class="form-control" placeholder="Identifiant" name="email"  autofocus="">
                </div>
                <div class="form-group">
                  <input class="form-control" placeholder="Mot de passe" name="password" type="password">
                </div>
                <div class="forget-password">
                  <p></p>
                  <p class="text-center"><br/>Mot de passe oubli&#233 ?<a href="#" id="link-forgot"> Cliquez ici<br/></a><br/></p>
                </div>
                <input name="submit" class="btn btn-primary" type="submit"  value= "Connexion" style="float: right;">

              </fieldset>

            </form>
          </div>
        </div>
      </div><!-- /.col-->
    </div><!-- /.row -->



    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/chart.min.js"></script>
    <script src="js/chart-data.js"></script>
    <script src="js/easypiechart.js"></script>
    <script src="js/easypiechart-data.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script>
    !function ($) {
      $(document).on("click","ul.nav li.parent > a > span.icon", function(){
        $(this).find('em:first').toggleClass("glyphicon-minus");
      });
      $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
    }(window.jQuery);

    $(window).on('resize', function () {
      if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
    })
    $(window).on('resize', function () {
      if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
    })
    </script>

  </body>
  </html>

  <?php

} // Fin du else.

// Fin du code. :)
?>
