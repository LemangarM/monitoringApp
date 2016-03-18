<?php
session_start();// À placer obligatoirement avant tout code HTML.
if (isset($_POST['logoutValue']) ) // Si les variables existent.
{
  $logoutValue=$_POST['logoutValue'];
}

else
{
  $logoutValue="";
}

if( $logoutValue==1){$_SESSION['connect']==0;}
if($_SESSION['connect']==1){

?>

<?php
//Auto chargement des classes
function __autoload($class_name)
{
    include $class_name . '.php';
}
?>
  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MonitoringApplis - Barometer</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/datepicker3.css" rel="stylesheet">
    <link href="css/bootstrap-table.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">

    <!--Icons-->
    <script src="js/lumino.glyphs.js"></script>
    
  </head>

  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"><span>Monitoring</span>Applis</a>
          <ul class="user-menu">
            <li class="dropdown pull-right">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> <?php echo $_SESSION['login']; ?> <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Profile</a></li>
                <li><a href="#"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"></use></svg> Settings</a></li>
                <li><a onclick='document.getElementById("logout").submit()' href="login.php"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
              </ul>
            </li>
          </ul>
        </div>

      </div><!-- /.container-fluid -->
    </nav>

    <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
      <form role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
      </form>
      <ul class="nav menu">
        <li><a href="index.php"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Dashboard</a></li>
        <li><a href="charts.php"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> Charts</a></li>
        <li class="active"><a href="tables.php"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg> Barometer</a></li>
        <li><a href="reviews.php"><svg class="glyph stroked two messages"><use xlink:href="#stroked-two-messages"/></svg> Reviews</a></li>

        <li role="presentation" class="divider"></li>
        <li><a href="login.php"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Login Page</a></li>
      </ul>

    </div><!--/.sidebar-->

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
      <div class="row">
        <ol class="breadcrumb">
          <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
          <li class="active">Icons</li>
        </ol>
      </div><!--/.row-->

      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">Tables</h1>
        </div>
      </div><!--/.row-->

      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <!--	<div class="panel-heading">Barometre Applications Bouygues Telecom</div>-->
            <div class="panel-body">
              <form action="tables.php" method="POST">
                <div class="radio">
                  <label>
                    <input type="radio" onchange="this.form.submit()" name="optionsRadios" id="optionsRadios1" value="00%" <?php if(isset($_POST['optionsRadios']) && $_POST['optionsRadios']=='00%') { echo ' checked="checked"'; } ?> >Google Play
                  </label>
                  <label>
                    <input type="radio" onchange="this.form.submit()" name="optionsRadios" id="optionsRadios2" value="xxx" <?php if(isset($_POST['optionsRadios']) && $_POST['optionsRadios']!=='00%') { echo ' checked="checked"'; } ?>>App Store
                  </label>
                </div>
              </form>

            <?php

            if(isset($_POST['optionsRadios']) && $_POST['optionsRadios'] == "00%")
            {
                $barometerData = \Models\Tables\Barometer::getAndroidBarometer();
            }
            elseif(isset($_POST['optionsRadios']) && $_POST['optionsRadios'] !== "00%")
            {
                $barometerData = \Models\Tables\Barometer::getIosBarometer();
            }
            else
            {
                $barometerData = \Models\Tables\Barometer::getBarometer();
            }

            \Models\functions::createJsonFile($barometerData)

            ?>

              <table data-toggle="table" data-url="tables/barometerData.json" data-show-refresh="true" data-show-toggle="false" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
                <thead>
                  <tr>
                    <!-- <th data-field="state" data-checkbox="true" >note actuelle</th> -->
                      <th data-field="appName" data-sortable="true">Applications</th>
                    <th data-field="image">Icones</th>
                    <th data-field="store">Store</th>
                    <th data-field="appTotalStars"  data-sortable="true">Notes</th>
                    <th data-field="Unites_total" data-sortable="true">Téléchargements/mois</th>
                    <th data-field="Unites_cumul" data-sortable="true">Cumuls</th>
                    <th data-field="DateMeasure" data-sortable="true">Dates</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>

<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/chart.min.js"></script>
<script src="js/chart-data.js"></script>
<script src="js/easypiechart.js"></script>
<script src="js/easypiechart-data.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/bootstrap-table.js"></script>
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
}
else // Le mot de passe n'est pas bon.
{
  header('Location: login.php');

} // Fin du else.

// Fin du code. émoticône smile
?>
