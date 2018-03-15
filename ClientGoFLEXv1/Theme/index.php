<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>GOFLEX-Client</title>

    <?php

    ?>

    <!-- Bootstrap core CSS -->
    <link href="../../views/assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="../../views/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../../views/assets/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="../../views/assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="../../views/assets/lineicons/style.css">

    <!-- Custom styles for this template -->
    <link href="../../views/assets/css/style.css" rel="stylesheet">
    <link href="../../views/assets/css/style-responsive.css" rel="stylesheet">

    <script src="../../views/assets/js/chart-master/Chart.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<section id="container" >
    <!-- **********************************************************************************************************************************************************
    TOP BAR CONTENT & NOTIFICATIONS
    *********************************************************************************************************************************************************** -->
    <!--header start-->
    <header class="header black-bg">
        <div class="sidebar-toggle-box">
            <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
        </div>
        <!--logo start-->
        <a href="index.php" class="logo"><b>GOFLEX</b></a>
        <!--logo end-->
        <div class="nav notify-row" id="top_menu">
            <!--  notification start -->
            <ul class="nav top-menu">

                <!-- inbox dropdown start-->
                <li id="header_inbox_bar" class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="index.php#">
                        <i class="fa fa-envelope-o"></i>
                        <span class="badge bg-theme">5</span>
                    </a>
                    <ul class="dropdown-menu extended inbox">
                        <div class="notify-arrow notify-arrow-green"></div>
                        <li>
                            <p class="green">Vous avez 5 nouveaux messages</p>
                        </li>
                        <li>
                            <a href="index.php#">
                                <span class="photo"><img alt="avatar" src="../../views/assets/img/ui-zac.jpg"></span>
                                <span class="subject">
                                    <span class="from">ESR Service-technique</span>
                                    <span class="time">1 heure</span>
                                    </span>
                                <span class="message">
                                     Réception GOFLEX-Box
                                    </span>
                            </a>
                        </li>
                        <li>
                            <a href="index.php#">
                                <span class="photo"><img alt="avatar" src="../../views/assets/img/ui-divya.jpg"></span>
                                <span class="subject">
                                    <span class="from">ESR Service-technique</span>
                                    <span class="time">1 jour</span>
                                    </span>
                                <span class="message">
                                     Installation GOFLEX-box
                                    </span>
                            </a>
                        </li>
                        <li>
                            <a href="index.php#">
                                <span class="photo"><img alt="avatar" src="../../views/assets/img/ui-danro.jpg"></span>
                                <span class="subject">
                                    <span class="from">ESR Service-client</span>
                                    <span class="time">15 jours</span>
                                    </span>
                                <span class="message">
                                        Nouvelles offres ESR
                                    </span>
                            </a>
                        </li>
                        <li>
                            <a href="index.php#">
                                <span class="photo"><img alt="avatar" src="../../views/assets/img/ui-sherman.jpg"></span>
                                <span class="subject">
                                    <span class="from">ESR Service-technique</span>
                                    <span class="time">1 mois</span>
                                    </span>
                                <span class="message">
                                        Installation GOFLEX-box
                                    </span>
                            </a>
                        </li>
                        <li>
                            <a href="index.php#">Voir tous les messages</a>
                        </li>
                    </ul>
                </li>
                <!-- inbox dropdown end -->
            </ul>
            <!--  notification end -->
        </div>
        <div class="top-menu">
            <ul class="nav pull-right top-menu">
                <li><a class="logout" href="../../views/login.html">Logout</a></li>
            </ul>
        </div>
    </header>
    <!--header end-->

    <!-- **********************************************************************************************************************************************************
    MAIN SIDEBAR MENU
    *********************************************************************************************************************************************************** -->
    <!--sidebar start-->
    <aside>
        <div id="sidebar"  class="nav-collapse ">
            <!-- sidebar menu start-->
            <ul class="sidebar-menu" id="nav-accordion">

                <p class="centered"><a href="profile.html"><img src="../../views/assets/img/ui-sam.jpg" class="img-circle" width="60"></a></p>
                <h5 class="centered">Pierre Roduit</h5>

                <li class="mt">
                    <a class="active" href="index.php">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>


                <li class="sub-menu">
                    <a href="javascript:;" >
                        <i class="fa fa-book"></i>
                        <span>Paramètres</span>
                    </a>
                    <ul class="sub">
                        <li><a  href="blank.html">Contact</a></li>
                        <li><a  href="../../views/login.html">Login</a></li>
                        <li><a  href="lock_screen.html">Lock Screen</a></li>
                    </ul>
                </li>


            </ul>
            <!-- sidebar menu end-->
        </div>
    </aside>
    <!--sidebar end-->

    <!-- **********************************************************************************************************************************************************
    MAIN CONTENT
    *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">

            <div class="row">
                <div class="col-lg-9 main-chart">
                    <div class="border-head">
                        <h3>PUISSANCE</h3>
                    </div>
                    <div class="custom-bar-chart">

                    </div>

                    <div class="border-head">
                        <h3>TEMPERATURE</h3>
                    </div>
                    <div class="custom-bar-chart">
                        <ul class="y-axis">
                            <li><span>10.000</span></li>
                            <li><span>8.000</span></li>
                            <li><span>6.000</span></li>
                            <li><span>4.000</span></li>
                            <li><span>2.000</span></li>
                            <li><span>0</span></li>
                        </ul>
                        <div class="bar">
                            <div class="title">JAN</div>
                            <div class="value tooltips" data-original-title="8.500" data-toggle="tooltip" data-placement="top">85%</div>
                        </div>
                        <div class="bar ">
                            <div class="title">FEB</div>
                            <div class="value tooltips" data-original-title="5.000" data-toggle="tooltip" data-placement="top">50%</div>
                        </div>
                        <div class="bar ">
                            <div class="title">MAR</div>
                            <div class="value tooltips" data-original-title="6.000" data-toggle="tooltip" data-placement="top">60%</div>
                        </div>
                        <div class="bar ">
                            <div class="title">APR</div>
                            <div class="value tooltips" data-original-title="4.500" data-toggle="tooltip" data-placement="top">45%</div>
                        </div>
                        <div class="bar">
                            <div class="title">MAY</div>
                            <div class="value tooltips" data-original-title="3.200" data-toggle="tooltip" data-placement="top">32%</div>
                        </div>
                        <div class="bar ">
                            <div class="title">JUN</div>
                            <div class="value tooltips" data-original-title="6.200" data-toggle="tooltip" data-placement="top">62%</div>
                        </div>
                        <div class="bar">
                            <div class="title">JUL</div>
                            <div class="value tooltips" data-original-title="7.500" data-toggle="tooltip" data-placement="top">75%</div>
                        </div>
                    </div>







                </div><!-- /col-lg-9 END SECTION MIDDLE -->


                <!-- **********************************************************************************************************************************************************
                RIGHT SIDEBAR CONTENT
                *********************************************************************************************************************************************************** -->

                <div class="col-lg-3 ds">
                    <!--COMPLETED ACTIONS DONUTS CHART-->
                    <h3>NOTIFICATIONS</h3>

                    <!-- First Action -->
                    <div class="desc">
                        <div class="thumb">
                            <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                        </div>
                        <div class="details">
                            <p><muted>1 heure</muted><br/>
                                <a href="#">ESR-Service technique</a> subscribed to your newsletter.<br/>
                            </p>
                        </div>
                    </div>
                    <!-- Second Action -->
                    <div class="desc">
                        <div class="thumb">
                            <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                        </div>
                        <div class="details">
                            <p><muted>1 jour</muted><br/>
                                <a href="#">ESR-Service technique</a>Test box<br/>
                            </p>
                        </div>
                    </div>
                    <!-- Third Action -->
                    <div class="desc">
                        <div class="thumb">
                            <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                        </div>
                        <div class="details">
                            <p><muted>15 jours</muted><br/>
                                <a href="#">ESR-Service client</a>Reception box <br/>
                            </p>
                        </div>
                    </div>
                    <!-- Fourth Action -->
                    <div class="desc">
                        <div class="thumb">
                            <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                        </div>
                        <div class="details">
                            <p><muted>1 mois</muted><br/>
                                <a href="#">ESR-Service technique</a>Installation box<br/>
                            </p>
                        </div>
                    </div>
                    <!-- Fifth Action -->
                    <div class="desc">
                        <div class="thumb">
                            <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                        </div>
                        <div class="details">
                            <p><muted>2 mois</muted><br/>
                                <a href="#">Daniel Pratt</a>Installation box<br/>
                            </p>
                        </div>
                    </div>
                </div><!-- /col-lg-3 -->
            </div><! --/row -->
        </section>
    </section>

    <!--main content end-->
    <!--footer start-->
    <footer class="site-footer">
        <div class="text-center">
            2014 - Alvarez.is
            <a href="index.php#" class="go-top">
                <i class="fa fa-angle-up"></i>
            </a>
        </div>
    </footer>
    <!--footer end-->
</section>

<!-- js placed at the end of the document so the pages load faster -->
<script src="../../views/assets/js/jquery.js"></script>
<script src="../../views/assets/js/jquery-1.8.3.min.js"></script>
<script src="../../views/assets/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../../views/assets/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../../views/assets/js/jquery.scrollTo.min.js"></script>
<script src="../../views/assets/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="../../views/assets/js/jquery.sparkline.js"></script>


<!--common script for all pages-->
<script src="../../views/assets/js/common-scripts.js"></script>

<script type="text/javascript" src="../../views/assets/js/gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="../../views/assets/js/gritter-conf.js"></script>

<!--script for this page-->
<script src="../../views/assets/js/sparkline-chart.js"></script>
<script src="../../views/assets/js/zabuto_calendar.js"></script>

<script type="application/javascript">
    $(document).ready(function () {
        $("#date-popover").popover({html: true, trigger: "manual"});
        $("#date-popover").hide();
        $("#date-popover").click(function (e) {
            $(this).hide();
        });

        $("#my-calendar").zabuto_calendar({
            action: function () {
                return myDateFunction(this.id, false);
            },
            action_nav: function () {
                return myNavFunction(this.id);
            },
            ajax: {
                url: "show_data.php?action=1",
                modal: true
            },
            legend: [
                {type: "text", label: "Special event", badge: "00"},
                {type: "block", label: "Regular event", }
            ]
        });
    });


    function myNavFunction(id) {
        $("#date-popover").hide();
        var nav = $("#" + id).data("navigation");
        var to = $("#" + id).data("to");
        console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
    }
</script>


</body>
</html>
