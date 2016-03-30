<?php
session_start(); // Démarage de la session
if (isset($_POST['logoutValue'])) { // Si les variables existent.
    $logoutValue = $_POST['logoutValue'];
} else {
    $logoutValue = "";
}

if ($logoutValue == 1) {
    $_SESSION['connect'] = 0;
}
if ($_SESSION['connect'] == 1) {
    ?>
    <?php

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
            <title>MonitoringApplis- Charts</title>

            <link href="css/bootstrap.min.css" rel="stylesheet">
            <link href="css/bootstrap-datepicker.css" rel="stylesheet">
            <link href="css/datepicker3.css" rel="stylesheet">
            <link href="css/styles.css" rel="stylesheet">
            <link href="css/monitoring-app.css" rel="stylesheet">

            <!--Icons-->
            <script src="js/lumino.glyphs.js"></script>

            <!--[if lt IE 9]>
            <script src="js/html5shiv.js"></script>
            <script src="js/respond.min.js"></script>
            <![endif]-->

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
                        <a class="navbar-brand" href="#"><span>Monitoring</span>Applis</a>
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
                <?php if (filter_input(INPUT_GET, 'id_app')) { ?>
                    <?php foreach (Models\Tables\Charts::appName(filter_input(INPUT_GET, 'id_app')) as $data) : ?>
                        <div class="form-group">
                            <img src="images/<?php echo $data->appName ?>.png" id="img">
                        </div>
                        <div class="entity-name" itemprop="name"><?php echo $data->appName ?></div>
                    <?php endforeach; ?>
                <?php } else { ?>
                    <?php foreach (Models\Tables\Charts::appName() as $data) : ?>
                        <div class="form-group">
                            <img src="images/B.tv mobile.png" id="img">
                        </div>
                        <div class="entity-name" itemprop="name"><?php echo $data->appName ?></div>
                    <?php endforeach; ?>
                <?php } ?>
                        <li role="presentation" class="divider" id="divider"></li>

                <ul class="nav menu">
                    <li><a href="index.php"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg> Barometètre</a></li>
                    <li class="active"><a href="charts.php"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg>Vue Détaillée</a></li>
                    <li><a href="reviews.php"><svg class="glyph stroked two messages"><use xlink:href="#stroked-two-messages"/></svg> Reviews</a></li>
                    <li><a href="alerting.php"><svg class="glyph stroked sound on"><use xlink:href="#stroked-sound-on"/></svg> Alerting</a></li>
                    <li role="presentation" class="divider"></li>
                    <li><a href="login.php"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Login Page</a></li>
                </ul>
            </div><!--/.sidebar-->

            <!--======================================================= APPS DROPDOWNLIST AND CALENDAR  ==============================================================-->

            <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
                </br>
                <?php $app_name_list = Models\Tables\Charts::getAppNameList(); ?>
                <div class="col-lg-12" id="list">
                    <form method="get" role="form">
                        <div class="col-md-10">
                            <div class="form-group">
                                <select name="id_app" class="form-control">
                                    <?php
                                    if (filter_input(INPUT_GET, 'id_app')) {
                                        $selecteur = filter_input(INPUT_GET, 'id_app');
                                    } else {
                                        $selecteur = "";
                                    }
                                    foreach ($app_name_list as $data) {
                                        echo '<option value="' . $data->appIdAllStore . '"';
                                        if ($selecteur === $data->appIdAllStore) {
                                            echo 'selected="selected"';
                                        }
                                        echo '>' . $data->appName . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2" id="button-app">
                            <button type="submit" class="btn btn-primary btn-md" id="btn-app">Valider</button>
                        </div>
                    </form>
                </div>  <!--   Fin Liste Déroulante -->

                <!--======================================================= FIN APPS DROPDOWNLIST AND CALENDAR  ==============================================================-->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Informations Générales</div>
                            <table class="table table-striped" id="infos">
                                <thead>
                                    <tr>
                                        <th>Store</th>
                                        <th>Version</th>
                                        <th>Version OS</th>
                                        <th>Note</th>
                                        <th>Sales</th>
                                        <th>Total Sales</th>
                                        <th>Mise à jour</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (filter_input(INPUT_GET, 'id_app')) { ?>
                                        <?php foreach (Models\Tables\Charts::InfosAndroid(filter_input(INPUT_GET, 'id_app')) as $data): ?>
                                            <tr>
                                                <td>Android</td>
                                                <td><?php echo $data->appVersion ?></td>
                                                <td><?php echo $data->appMinimumOsVersion ?></td>
                                                <td><?php echo $data->appTotalStars ?></td>
                                                <td><?php echo $data->Unites_total ?></td>
                                                <td><?php echo $data->Unites_cumul ?></td>
                                                <td><?php echo $data->currentVersionReleaseDate ?></td>
                                            </tr>
                                        <?php endforeach; ?>

                                        <?php foreach (Models\Tables\Charts::InfosIos(filter_input(INPUT_GET, 'id_app')) as $data): ?>
                                            <tr>
                                                <td>iOS</td>
                                                <td><?php echo $data->appVersion ?></td>
                                                <td><?php echo $data->appMinimumOsVersion ?></td>
                                                <td><?php echo $data->appTotalStars ?></td>
                                                <td><?php echo $data->Unites_total ?></td>
                                                <td><?php echo $data->Unites_cumul ?></td>
                                                <td><?php echo $data->currentVersionReleaseDate ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php } else { ?>
                                        <?php foreach (Models\Tables\Charts::InfosAndroid() as $data): ?>
                                            <tr>
                                                <td>Android</td>
                                                <td><?php echo $data->appVersion ?></td>
                                                <td><?php echo $data->appMinimumOsVersion ?></td>
                                                <td><?php echo $data->appTotalStars ?></td>
                                                <td><?php echo $data->Unites_total ?></td>
                                                <td><?php echo $data->Unites_cumul ?></td>
                                                <td><?php echo $data->currentVersionReleaseDate ?></td>
                                            </tr>
                                        <?php endforeach; ?>

                                        <?php foreach (Models\Tables\Charts::InfosIos() as $data): ?>
                                            <tr>
                                                <td>iOS</td>
                                                <td><?php echo $data->appVersion ?></td>
                                                <td><?php echo $data->appMinimumOsVersion ?></td>
                                                <td><?php echo $data->appTotalStars ?></td>
                                                <td><?php echo $data->Unites_total ?></td>
                                                <td><?php echo $data->Unites_cumul ?></td>
                                                <td><?php echo $data->currentVersionReleaseDate ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">Notes</div>

                            <div class="panel-body">
                                <div class="canvas-wrapper">
                                    <canvas class="main-chart" id="notes-chart" height="300" width="600"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">Visiteurs</div>
                            <div class="panel-body">
                                <div class="canvas-wrapper">
                                    <canvas class="main-chart" id="bar-chart" height="300" width="600"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--/.row-->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Install & Uninstall & Upgrade</div>

                            <div class="panel-body">
                                <div class="canvas-wrapper">
                                    <canvas class="main-chart" id="line-chart" height="200" width="600"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--/.row-->
            </div><!--/.main-->

            <!--======================================================= PREPARATION DE LA DATA ==============================================================-->
            <?php
            // Install & uninstall & upgrade line chart array
            $date = array();
            $install_android = array();
            $install_ios = array();
            $uninstall = array();
            $upgrade = array();

            // Visitors bar chart array
            $date_visitors = array();
            $visitors_android = array();
            $visitors_ios = array();

            // Notes line chart array
            $date_notes = array();
            $notes_android = array();
            $notes_android_total = array();
            $notes_ios = array();

            /*
             * Install & uninstall & upgrade line chart
             */
            if (filter_input(INPUT_GET, 'id_app')) {
                $chart_sales_android = Models\Tables\Charts::getSalesAndroid(filter_input(INPUT_GET, 'id_app'));
                $chart_sales_ios = Models\Tables\Charts::getSalesIos(filter_input(INPUT_GET, 'id_app'));
            } else {
                $chart_sales_android = Models\Tables\Charts::getSalesAndroid();
                $chart_sales_ios = Models\Tables\Charts::getSalesIos();
            }




            foreach ($chart_sales_android as $data) {
                array_push($date, $data->DateMeasure);
                array_push($install_android, $data->Unites);
                array_push($uninstall, $data->Daily_uninstall);
                array_push($upgrade, $data->Daily_upgrade);
            }

            foreach ($chart_sales_ios as $data) {
                array_push($install_ios, $data->Unites);
            }

            //convert Date Format to month Name and Year
            $dateMa = array();
            $convertDate = array();
            $monthday = array();
            for ($i = 0; $i < count($chart_sales_android); $i++) {
                $convertDate = strtotime($chart_sales_android[$i]->DateMeasure);
                $dateMa = date('d-M', $convertDate);
                array_push($monthday, $dateMa);
            }

            // inverser l'ordre des éléments

            $date = array_reverse($monthday);
            $install_android = array_reverse($install_android);
            $install_ios = array_reverse($install_ios);
            $uninstall = array_reverse($uninstall);
            $upgrade = array_reverse($upgrade);

            /*
             * Visitors bar chart
             */
            if (filter_input(INPUT_GET, 'id_app')) {
                $chart_visitors_android = \Models\Tables\Charts::getVisitorsAndroid(filter_input(INPUT_GET, 'id_app'));
                $chart_visitors_ios = Models\Tables\Charts::getVisitorsIos(filter_input(INPUT_GET, 'id_app'));
            } else {
                $chart_visitors_android = \Models\Tables\Charts::getVisitorsAndroid();
                $chart_visitors_ios = Models\Tables\Charts::getVisitorsIos();
            }

            foreach ($chart_visitors_android as $data) {
                array_push($visitors_android, $data->Unites);
                array_push($date_visitors, $data->DateMeasure);
            }

            foreach ($chart_visitors_ios as $data) {
                array_push($visitors_ios, $data->Unites);
            }

            //convert Date Format to month Name and Year
            $dateM = array();
            $convertDate = array();
            $month = array();
            for ($i = 0; $i < count($chart_visitors_android); $i++) {
                $convertDate = strtotime($chart_visitors_android[$i]->DateMeasure);
                $dateM = date('M', $convertDate);
                array_push($month, $dateM);
            }

            $visitors_android = array_reverse($visitors_android);
            $visitors_ios = array_reverse($visitors_ios);
            $date_visitors = array_reverse($month);


            /*
             * Notes line chart
             */
            if (filter_input(INPUT_GET, 'id_app')) {
                $chart_notes_android = \Models\Tables\Charts::getNotesAndroid(filter_input(INPUT_GET, 'id_app'));
                $chart_notes_ios = Models\Tables\Charts::getNotesIos(filter_input(INPUT_GET, 'id_app'));
            } else {
                $chart_notes_android = \Models\Tables\Charts::getNotesAndroid();
                $chart_notes_ios = Models\Tables\Charts::getNotesIos();
            }
            foreach ($chart_notes_android as $data) {
                array_push($date_notes, $data->DateMeasure);
                array_push($notes_android, $data->Daily_Average_Rating);
                array_push($notes_android_total, $data->Total_Average_Rating);
            }

            foreach ($chart_notes_ios as $data) {
                array_push($notes_ios, $data->Total_Average_Rating);
            }

            //convert Date Format to month Name and Year
            $date_notes = array();
            $convertDate = array();
            $monthday = array();

            for ($i = 0; $i < count($chart_notes_android); $i++) {
                $convertDate = strtotime($chart_notes_android[$i]->DateMeasure);
                $date_notes = date('d-M', $convertDate);
                array_push($monthday, $date_notes);
            }

            // inverser l'ordre des éléments
            $date_notes = array_reverse($monthday);
            $notes_android = array_reverse($notes_android);
            $notes_android_total = array_reverse($notes_android_total);
            $notes_ios = array_reverse($notes_ios);
            ?>

            <!--============================================================= CHART DATA =======================================================================-->

            <script>
                // Install & uninstall & upgrade line chart
                var date_de_mesure = <?= json_encode($date) ?>;
                var telechargement_android = <?= json_encode($install_android) ?>;
                var telechargement_ios = <?= json_encode($install_ios) ?>;
                var desinstalation = <?= json_encode($uninstall) ?>;
                var mise_a_jour = <?= json_encode($upgrade) ?>;

                // Visitors bar chart
                var visiteurs_android = <?= json_encode($visitors_android) ?>;
                var visiteurs_ios = <?= json_encode($visitors_ios) ?>;
                var visiteurs_date = <?= json_encode($date_visitors) ?>;

                // Notes line chart
                var notes_date = <?= json_encode($date_notes) ?>;
                var notes_android = <?= json_encode($notes_android) ?>;
                var notes_ios = <?= json_encode($notes_ios) ?>;
                var notes_android_total = <?= json_encode($notes_android_total) ?>;

                var lineChartData = {
                    labels: date_de_mesure,
                    datasets: [
                        {
                            label: "désinstallations (rouge)",
                            fillColor: "rgba(255,255,255,0)",
                            strokeColor: "rgba(238,44,44,1)",
                            pointColor: "rgba(238,44,44,1)",
                            pointStrokeColor: "#fff",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(220,220,220,1)",
                            data: desinstalation
                        },
                        {
                            label: "téléchargements android (bleu foncé)",
                            fillColor: "rgba(255,255,255,0)",
                            strokeColor: "rgb(0, 102, 153)",
                            pointColor: "rgb(0, 102, 153)",
                            pointStrokeColor: "#fff",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(48, 164, 255, 1)",
                            data: telechargement_android
                        },
                        {
                            label: "téléchargements ios (bleu clair)",
                            fillColor: "rgba(255,255,255,0)",
                            strokeColor: "rgba(48, 164, 255, 1)",
                            pointColor: "rgba(48, 164, 255, 1)",
                            pointStrokeColor: "#fff",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(48, 164, 255, 1)",
                            data: telechargement_ios
                        },
                        {
                            label: "Mise à jour (jaune)",
                            fillColor: "rgba(255,255,255,0)",
                            strokeColor: "#FFB53E",
                            pointColor: "#FFB53E",
                            pointStrokeColor: "#fff",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(48, 164, 255, 1)",
                            data: mise_a_jour
                        }
                    ]
                }

                var notesChartData = {
                    labels: notes_date,
                    datasets: [
                        {
                            label: "Total average rating (bleu)",
                            fillColor: "rgba(255,255,255,0)",
                            strokeColor: "rgba(48, 164, 255, 1)",
                            pointColor: "rgba(48, 164, 255, 1)",
                            pointStrokeColor: "#fff",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(48, 164, 255, 1)",
                            data: notes_ios
                        },
                        {
                            label: "Daily average rating (violet)",
                            fillColor: "rgba(255,255,255,0)",
                            strokeColor: "rgb(153, 153, 255)",
                            pointColor: "rgb(153, 153, 255)",
                            pointStrokeColor: "#fff",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(220,220,220,1)",
                            data: notes_android
                        },
                        {
                            label: "Total average rating (violet foncé)",
                            fillColor: "rgba(255,255,255,0)",
                            strokeColor: "rgb(102, 0, 204)",
                            pointColor: "rgb(102, 0, 204)",
                            pointStrokeColor: "#fff",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(48, 164, 255, 1)",
                            data: notes_android_total
                        }
                    ]
                }

                var barChartData = {
                    labels: visiteurs_date,
                    datasets: [
                        {
                            fillColor: "rgb(204, 204, 255)",
                            strokeColor: "rgb(153, 153, 255)",
                            highlightFill: "rgb(153, 153, 255)",
                            highlightStroke: "rgb(128, 128, 255)",
                            data: visiteurs_android
                        },
                        {
                            fillColor: "rgba(48, 164, 255, 0.2)",
                            strokeColor: "rgba(48, 164, 255, 0.8)",
                            highlightFill: "rgba(48, 164, 255, 0.75)",
                            highlightStroke: "rgba(48, 164, 255, 1)",
                            data: visiteurs_ios
                        }
                    ]
                }

                window.onload = function () {
                    var chart1 = document.getElementById("line-chart").getContext("2d");
                    window.myLine = new Chart(chart1).Line(lineChartData, {
                        responsive: true
                    });
                    var chart2 = document.getElementById("bar-chart").getContext("2d");
                    window.myBar = new Chart(chart2).Bar(barChartData, {
                        responsive: true
                    });
                    var chart3 = document.getElementById("notes-chart").getContext("2d");
                    window.myLine = new Chart(chart3).Line(notesChartData, {
                        responsive: true
                    });
                    /*var chart3 = document.getElementById("doughnut-chart").getContext("2d");
                     window.myDoughnut = new Chart(chart3).Doughnut(doughnutData, {responsive: true
                     });
                     var chart4 = document.getElementById("pie-chart").getContext("2d");
                     window.myPie = new Chart(chart4).Pie(pieData, {responsive: true
                     });*/


                };
            </script> <!--fin insert DATA -->

            <script src="js/jquery-1.11.1.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script src="js/chart.min.js"></script>
            <!--<script src="js/chart-data.js"></script>-->
            <script src="js/easypiechart.js"></script>
            <script src="js/easypiechart-data.js"></script>
            <script src="js/bootstrap-datepicker.js"></script>
            <script src="js/bootstrap-datepicker.fr.js" charset="UTF-8"></script>

            <script>
                !function ($) {
                    $(document).on("click", "ul.nav li.parent > a > span.icon", function () {
                        $(this).find('em:first').toggleClass("glyphicon-minus");
                    });
                    $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
                }(window.jQuery);
                $(window).on('resize', function () {
                    if ($(window).width() > 768)
                        $('#sidebar-collapse').collapse('show')
                });
                $(window).on('resize', function () {
                    if ($(window).width() <= 767)
                        $('#sidebar-collapse').collapse('hide')
                });
                //START DATE
                $('#datepickerstart').datepicker({
                    format: 'yyyy-mm-dd',
                    endDate: new Date(),
                    language: 'fr',
                    todayBtn: true,
                    autoclose: true
                            //startDate: '-1d'
                });
                //$('#datepickerstart').datepicker('setDate','-30d');
                $('#datepickerstart').datepicker('getDate');
                //END DATE
                $('#datepickerend').datepicker({
                    format: 'yyyy-mm-dd',
                    endDate: new Date(),
                    language: 'fr',
                    todayBtn: true,
                    autoclose: true
                });
                //$('#datepickerend').datepicker('setDate','0')

                $("#datepickerend").on("dp.change", function (e) {
                    $('#datepickerstart').data("DateTimePicker").minDate(e.date);
                });
                $("#datepickerstart").on("dp.change", function (e) {
                    $('#datepickerend').data("DateTimePicker").maxDate(e.date);
                });
            </script>

    </html>
    <?php
} else { // Le mot de passe n'est pas bon.
    header('Location: login.php');
} // Fin du else.
// Fin du code. :)
?>
