<?php
$nombre1 = $this->session->userdata('nombre1');

$apellido1 = $this->session->userdata('apellido1');

$codigo_perfil = $this->session->userdata('codigo_perfil');


$rol = 1;
if ($codigo_perfil == 'PE0483143841') {
    $rol = 1;
} else if ($codigo_perfil == 'PE0483143842') {
    $rol = 2;
} else {
    $rol = 3;
}
// $rol = 3;
?>

<!DOCTYPE html>
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html class="no-js" lang="es">
<!--<![endif]-->


<script type="text/javascript" src="<?php echo base_url() ?>bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/notify.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/general.js?v=<?php echo rand() ?>"></script>




<head>
    <title>SM MasterMind</title>
    <link rel="icon" href="/img/logo.ico" />
    <!-- start: META -->
    <meta charset="utf-8" />
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="Responsive Admin Template build with Twitter Bootstrap and jQuery" name="description" />
    <meta content="ClipTheme" name="author" />
    <!-- end: META -->
    <!-- start: MAIN CSS -->

    <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>css/general.css?v=<?php echo rand() ?>" />

    <link type="text/css" rel="stylesheet"
        href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700|Raleway:400,100,200,300,500,600,700,800,900/" />
    <link type="text/css" rel="stylesheet"
        href="<?php echo base_url() ?>bower_components/bootstrap/dist/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet"
        href="<?php echo base_url() ?>bower_components/font-awesome/css/font-awesome.min.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/fonts/clip-font.min.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>bower_components/iCheck/skins/all.css" />
    <link type="text/css" rel="stylesheet"
        href="<?php echo base_url() ?>bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css" />
    <link type="text/css" rel="stylesheet"
        href="<?php echo base_url() ?>bower_components/sweetalert/dist/sweetalert.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/css/main.min.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/css/main-responsive.min.css" />
    <link type="text/css" rel="stylesheet" media="print" href="<?php echo base_url() ?>assets/css/print.min.css" />
    <link type="text/css" rel="stylesheet" id="skin_color"
        href="<?php echo base_url() ?>assets/css/theme/light.min.css" />
    <!-- end: MAIN CSS -->
    <!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
    <!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->

</head>

<body>

    <!-- start: HEADER -->
    <div class="navbar navbar-inverse navbar-fixed-top">
        <!-- start: TOP NAVIGATION CONTAINER -->
        <div class="container" style="background-color: white;">
            <div class="navbar-header">
                <!-- start: RESPONSIVE MENU TOGGLER -->
                <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                    <span class="clip-list-2"></span>
                </button>
                <!-- end: RESPONSIVE MENU TOGGLER -->
                <!-- start: LOGO -->
                <a class="navbar-brand" href="home">

                    <i class="ccircle-img"> <img src="<?php echo base_url() ?>img/logo.png" class="" alt=""
                            style="height: 35px"> </i>
                    SM International Group
                </a>
                <!-- end: LOGO -->
            </div>
            <div class="navbar-tools">
                <!-- start: TOP NAVIGATION MENU -->
                <ul class="nav navbar-right">
                    <!-- start: TO-DO DROPDOWN -->
                    <li class="dropdown ocultar">
                        <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true"
                            href="#">
                            <i class="clip-list-5"></i>
                            <span class="badge"> 12</span>
                        </a>
                        <ul class="dropdown-menu todo">
                            <li>
                                <span class="dropdown-menu-title"> You have 12 pending tasks</span>
                            </li>
                            <li>
                                <div class="drop-down-wrapper">
                                    <ul>
                                        <li>
                                            <a class="todo-actions" href="javascript:void(0)">
                                                <i class="fa fa-square-o"></i>
                                                <span class="desc" style="opacity: 1; text-decoration: none;">Staff
                                                    Meeting</span>
                                                <span class="label label-danger" style="opacity: 1;"> today</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="todo-actions" href="javascript:void(0)">
                                                <i class="fa fa-square-o"></i>
                                                <span class="desc" style="opacity: 1; text-decoration: none;"> New
                                                    frontend layout</span>
                                                <span class="label label-danger" style="opacity: 1;"> today</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="todo-actions" href="javascript:void(0)">
                                                <i class="fa fa-square-o"></i>
                                                <span class="desc"> Hire developers</span>
                                                <span class="label label-warning"> tommorow</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="todo-actions" href="javascript:void(0)">
                                                <i class="fa fa-square-o"></i>
                                                <span class="desc">Staff Meeting</span>
                                                <span class="label label-warning"> tommorow</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="todo-actions" href="javascript:void(0)">
                                                <i class="fa fa-square-o"></i>
                                                <span class="desc"> New frontend layout</span>
                                                <span class="label label-success"> this week</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="todo-actions" href="javascript:void(0)">
                                                <i class="fa fa-square-o"></i>
                                                <span class="desc"> Hire developers</span>
                                                <span class="label label-success"> this week</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="todo-actions" href="javascript:void(0)">
                                                <i class="fa fa-square-o"></i>
                                                <span class="desc"> New frontend layout</span>
                                                <span class="label label-info"> this month</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="todo-actions" href="javascript:void(0)">
                                                <i class="fa fa-square-o"></i>
                                                <span class="desc"> Hire developers</span>
                                                <span class="label label-info"> this month</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="todo-actions" href="javascript:void(0)">
                                                <i class="fa fa-square-o"></i>
                                                <span class="desc" style="opacity: 1; text-decoration: none;">Staff
                                                    Meeting</span>
                                                <span class="label label-danger" style="opacity: 1;"> today</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="todo-actions" href="javascript:void(0)">
                                                <i class="fa fa-square-o"></i>
                                                <span class="desc" style="opacity: 1; text-decoration: none;"> New
                                                    frontend layout</span>
                                                <span class="label label-danger" style="opacity: 1;"> today</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="todo-actions" href="javascript:void(0)">
                                                <i class="fa fa-square-o"></i>
                                                <span class="desc"> Hire developers</span>
                                                <span class="label label-warning"> tommorow</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="view-all">
                                <a href="javascript:void(0)">
                                    See all tasks <i class="fa fa-arrow-circle-o-right"></i>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- start: MESSAGE DROPDOWN -->
                    <li class="dropdown ocultar">
                        <a class="dropdown-toggle" data-close-others="true" data-hover="dropdown" data-toggle="dropdown"
                            href="#">
                            <i class="clip-bubble-3"></i>
                            <span class="badge"> 9</span>
                        </a>
                        <ul class="dropdown-menu posts">
                            <li>
                                <span class="dropdown-menu-title"> You have 9 messages</span>
                            </li>
                            <li>
                                <div class="drop-down-wrapper">
                                    <ul>
                                        <li>
                                            <a href="javascript:;">
                                                <div class="clearfix">
                                                    <div class="thread-image">
                                                        <img alt=""
                                                            src="<?php echo base_url() ?>assets/images/avatar-2.jpg">
                                                    </div>
                                                    <div class="thread-content">
                                                        <span class="author">Nicole Bell</span>
                                                        <span class="preview">Duis mollis, est non commodo luctus, nisi
                                                            erat porttitor ligula, eget lacinia odio sem nec
                                                            elit.</span>
                                                        <span class="time"> Just Now</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <div class="clearfix">
                                                    <div class="thread-image">
                                                        <img alt=""
                                                            src="<?php echo base_url() ?>assets/images/avatar-1.jpg">
                                                    </div>
                                                    <div class="thread-content">
                                                        <span
                                                            class="author"><?php echo $nombre1 . " " . $apellido1 ?></span>
                                                        <span class="preview">Duis mollis, est non commodo luctus, nisi
                                                            erat porttitor ligula, eget lacinia odio sem nec
                                                            elit.</span>
                                                        <span class="time">2 mins</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <div class="clearfix">
                                                    <div class="thread-image">
                                                        <img alt=""
                                                            src="<?php echo base_url() ?>assets/images/avatar-3.jpg">
                                                    </div>
                                                    <div class="thread-content">
                                                        <span class="author">Steven Thompson</span>
                                                        <span class="preview">Duis mollis, est non commodo luctus, nisi
                                                            erat porttitor ligula, eget lacinia odio sem nec
                                                            elit.</span>
                                                        <span class="time">8 hrs</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <div class="clearfix">
                                                    <div class="thread-image">
                                                        <img alt=""
                                                            src="<?php echo base_url() ?>assets/images/avatar-1.jpg">
                                                    </div>
                                                    <div class="thread-content">
                                                        <span
                                                            class="author"><?php echo $nombre1 . " " . $apellido1 ?></span>
                                                        <span class="preview">Duis mollis, est non commodo luctus, nisi
                                                            erat porttitor ligula, eget lacinia odio sem nec
                                                            elit.</span>
                                                        <span class="time">9 hrs</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <div class="clearfix">
                                                    <div class="thread-image">
                                                        <img alt=""
                                                            src="<?php echo base_url() ?>assets/images/avatar-5.jpg">
                                                    </div>
                                                    <div class="thread-content">
                                                        <span class="author">Kenneth Ross</span>
                                                        <span class="preview">Duis mollis, est non commodo luctus, nisi
                                                            erat porttitor ligula, eget lacinia odio sem nec
                                                            elit.</span>
                                                        <span class="time">14 hrs</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="view-all">
                                <a href="pages_messages.html">
                                    See all messages <i class="fa fa-arrow-circle-o-right"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- end: MESSAGE DROPDOWN -->
                    <!-- start: USER DROPDOWN -->
                    <li class="dropdown current-user">
                        <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true"
                            href="#">
                            <img src="<?php echo base_url() ?>img/user.png" class="circle-img" alt=""
                                style="height: 32px">
                            <span class=""><?php echo $nombre1 . " " . $apellido1 ?></span>
                            <i class="clip-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="mi_perfil">
                                    <i class="clip-user-2"></i> &nbsp;Mi Perfil
                                </a>
                            </li>

                            <li>
                                <a href="login">
                                    <i class="clip-exit"></i> &nbsp;Cerrar Session
                                </a>
                            </li>

                        </ul>
                    </li>
                    <!-- end: USER DROPDOWN -->
                    <!-- start: PAGE SIDEBAR TOGGLE -->
                    <li class="ocultar">
                        <a class="sb-toggle" href="#"><i class="fa fa-outdent"></i></a>
                    </li>
                    <!-- end: PAGE SIDEBAR TOGGLE -->
                </ul>
                <!-- end: TOP NAVIGATION MENU -->
            </div>
        </div>
        <!-- end: TOP NAVIGATION CONTAINER -->
    </div>
    <!-- end: HEADER -->
    <!-- start: MAIN CONTAINER -->
    <div class="main-container">
        <div class="navbar-content">
            <!-- start: SIDEBAR -->
            <div class="main-navigation navbar-collapse collapse">
                <!-- start: MAIN MENU TOGGLER BUTTON -->
                <div class="navigation-toggler">
                    <i class="clip-chevron-left"></i>
                    <i class="clip-chevron-right"></i>
                </div>
                <!-- end: MAIN MENU TOGGLER BUTTON -->
                <!-- start: MAIN NAVIGATION MENU -->
                <ul class="main-navigation-menu">
                    <li>
                        <!--active open-->
                        <a href="home">
                            <i class="clip-home-3"></i>
                            <span class="title"> HOME </span><span class="selected"></span>
                        </a>
                    </li>

                    <?php if ($rol == 1 || $rol == 3) { ?>



                    <li>
                        <a href="javascript:void(0)">
                            <i class="clip-user-5"></i>
                            <span class="title"> FinAdvisor </span><i class="icon-arrow"></i>
                            <span class="selected"></span>
                        </a>

                        <ul class="sub-menu">
                            <li>
                                <a href="javascript:void(0)">
                                    <span class="title">Mis creencias </span><i class="icon-arrow"></i>
                                    <span class="selected"></span>
                                </a>

                                <ul class="sub-menu">
                                    <li>
                                        <a href="user_cre_lim">
                                            <i class="clip-balance"></i>
                                            <span class="title">Test de creencias </span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="user_rp">
                                            <i class="fa fa-envira"></i>
                                            <span class="title"> Test de Prosperidad </span>
                                        </a>
                                    </li>

                                </ul>

                            </li>




                            <li>
                                <a href="javascript:void(0)">
                                    <span class="title">Situación actual </span><i class="icon-arrow"></i>
                                    <span class="selected"></span>


                                    <ul class='sub-menu'>


                                        <li>

                                            <a href="javascript:;">
                                                <i class="fa fa-line-chart"></i>
                                                <span>Mapa de riqueza</span>

                                            </a>

                                            <ul class="sub-menu">

                                                <li>
                                                    <a href="user_valoractivos">
                                                        <i class='clip-home-3'></i>
                                                        <span> Mis Activos </span>

                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="user_deudas">
                                                        <i class='clip-clipboard'></i>
                                                        <span class="title"> Inventario deudas </span>
                                                    </a>
                                                </li>


                                            </ul>


                                        </li>


                                        <li>

                                            <a href="javascript:;">
                                                <i class="fa fa-money"></i>
                                                <span>Mi flujo de caja</span>

                                            </a>

                                            <ul class="sub-menu">
                                                <li>
                                                    <a href="user_valoringresos">
                                                        <span class="title">Entradas fijas</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="user_valoregresos">
                                                        <span class="title">Gastos Fijos</span>
                                                    </a>
                                                </li>



                                            </ul>


                                        </li>


                                    </ul>

                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <span class=" title">Mis indicadores</span><i class="icon-arrow"></i>
                                    <span class="selected"></span>

                                    <ul class='sub-menu'>

                                        <li>
                                            <a href="mis_indicadores">
                                                <i class="fa fa-pie-chart"></i>
                                                <span class="title">Indicadores </span>
                                            </a>
                                        </li>


                                    </ul>


                                </a>
                            </li>


                            <li>
                                <a href="javascript:void(0)">
                                    <span class="title">Modelo plenitud </span><i class="icon-arrow"></i>
                                    <span class="selected"></span>


                                    <ul class='sub-menu'>

                                        <li>
                                            <a href="user_valoringresos_ad">
                                                <i class="fa fa-bitcoin"></i>
                                                <span class="title">Simulador ingresos </span>
                                            </a>
                                        </li>


                                        <li>
                                            <a href="user_valoregresos_h">
                                                <i class="clip-bulb"></i>
                                                <span class="title">Simulador ahorro </span>
                                            </a>
                                        </li>


                                        <?php if ($rol == 3) { ?>
                                        <li>
                                            <a href="resumen_deuda">
                                                <i class="fa fa-child"></i>
                                                <span class="title">Simulador deudas</span>
                                            </a>
                                        </li>
                                        <?php } ?>


                                    </ul>

                            </li>




                            <li>

                                <a href="javascript:;">

                                    <span>Seguimiento</span><i class="icon-arrow"></i>

                                </a>



                            </li>


                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="clip-screen"></i>
                            <span class="title"> Reportes Usuario</span><i class="icon-arrow"></i>
                            <span class="selected"></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="user_flujodedinero">
                                    <span class="title"> Flujo de Dinero</span>
                                </a>
                            </li>
                            <li>
                                <a href="user_mapaderiqueza">
                                    <span class="title"> Mapa de Riqueza</span>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <?php } ?>


                    <?php if ($rol == 1) { ?>

                    <li>
                        <a href="javascript:void(0)">
                            <i class="clip-screen"></i>
                            <span class="title"> Administrar </span><i class="icon-arrow"></i>
                            <span class="selected"></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="preguntas_cl_admin">
                                    <span class="title"> Creencias</span>
                                </a>
                            </li>

                            <li>
                                <a href="preguntas_rp_admin">
                                    <span class="title"> Rueda de la prosperidad</span>
                                </a>
                            </li>
                            <li>
                                <a href="activos_admin">
                                    <span class="title"> Activos</span>
                                </a>
                            </li>
                            <li>
                                <a href="ingresos_admin">
                                    <span class="title"> Ingresos</span>
                                </a>
                            </li>
                            <li>
                                <a href="egresos_admin">
                                    <span class="title"> Egresos</span>
                                </a>
                            </li>

                            <li>
                                <a href="eventos_admin">
                                    <span class="title"> Eventos</span>
                                </a>
                            </li>

                            <li>
                                <a href="usuarios">
                                    <span class="title"> Usuarios</span>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <?php } ?>


                    <?php if ($rol == 1 || $rol == 2) { ?>

                    <li>
                        <a href="javascript:void(0)">
                            <i class="clip-screen"></i>
                            <span class="title"> Reportes </span><i class="icon-arrow"></i>
                            <span class="selected"></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="rep_admin_cre_lim">
                                    <span class="title"> Creencias</span>
                                </a>
                            </li>

                            <li>
                                <a href="rep_admin_mrp">
                                    <span class="title"> Rueda de la prosperidad</span>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <?php } ?>






                    <li class="ocultar">
                        <a href="http://www.cliptheme.com/preview/cliponeV2/Frontend/clip-one-template/clip-one/index.html"
                            target="_blank">
                            <i class="clip-cursor"></i>
                            <span class="title"> Frontend Theme </span><span class="selected"></span>
                        </a>
                    </li>

                </ul>
                <!-- end: MAIN NAVIGATION MENU -->
            </div>
            <!-- end: SIDEBAR -->
        </div>

        <!-- start: PAGE -->
        <div class="main-content">
            <!-- start: PANEL CONFIGURATION MODAL FORM -->
            <div class="modal fade" id="panel-config" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title">Panel Configuration</h4>
                        </div>
                        <div class="modal-body">
                            Here will be a configuration form
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Close
                            </button>
                            <button type="button" class="btn btn-primary">
                                Save changes
                            </button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <!-- end: SPANEL CONFIGURATION MODAL FORM -->
            <div class="container">
                <!-- start: PAGE HEADER -->
                <div class="row">
                    <div class="col-sm-12">
                        <!-- start: STYLE SELECTOR BOX -->
                        <div id="style_selector" class="hidden-xs close-style">
                            <div id="style_selector_container" style="display:block">
                                <div class="style-main-title">
                                    Style Selector
                                </div>
                                <div class="box-title">
                                    Choose Your Layout Style
                                </div>
                                <div class="input-box">
                                    <div class="input">
                                        <select name="layout">
                                            <option value="default">Wide</option>
                                            <option value="boxed">Boxed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="box-title">
                                    Choose Your Orientation
                                </div>
                                <div class="input-box">
                                    <div class="input">
                                        <select name="orientation">
                                            <option value="default">Default</option>
                                            <option value="rtl">RTL</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="box-title">
                                    Choose Your Header Style
                                </div>
                                <div class="input-box">
                                    <div class="input">
                                        <select name="header">
                                            <option value="fixed">Fixed</option>
                                            <option value="default">Default</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="box-title">
                                    Choose Your Footer Style
                                </div>
                                <div class="input-box">
                                    <div class="input">
                                        <select name="footer">
                                            <option value="default">Default</option>
                                            <option value="fixed">Fixed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="box-title">
                                    Backgrounds for Boxed Version
                                </div>
                                <div class="images boxed-patterns">
                                    <a id="bg_style_1" href="#"><img alt=""
                                            src="<?php echo base_url() ?>assets/images/bg.png"></a>
                                    <a id="bg_style_2" href="#"><img alt=""
                                            src="<?php echo base_url() ?>assets/images/bg_2.png"></a>
                                    <a id="bg_style_3" href="#"><img alt=""
                                            src="<?php echo base_url() ?>assets/images/bg_3.png"></a>
                                    <a id="bg_style_4" href="#"><img alt=""
                                            src="<?php echo base_url() ?>assets/images/bg_4.png"></a>
                                    <a id="bg_style_5" href="#"><img alt=""
                                            src="<?php echo base_url() ?>assets/images/bg_5.png"></a>
                                </div>
                                <div class="box-title">
                                    5 Predefined Color Schemes
                                </div>
                                <div class="images icons-color">
                                    <a id="light" href="#"><img class="active" alt=""
                                            src="<?php echo base_url() ?>assets/images/lightgrey.png"></a>
                                    <a id="dark" href="#"><img alt=""
                                            src="<?php echo base_url() ?>assets/images/darkgrey.png"></a>
                                    <a id="black-and-white" href="#"><img alt=""
                                            src="<?php echo base_url() ?>assets/images/blackandwhite.png"></a>
                                    <a id="navy" href="#"><img alt=""
                                            src="<?php echo base_url() ?>assets/images/navy.png"></a>
                                    <a id="green" href="#"><img alt=""
                                            src="<?php echo base_url() ?>assets/images/green.png"></a>
                                </div>
                                <div style="height:25px;line-height:25px; text-align: center">
                                    <a class="clear_style" href="#">
                                        Clear Styles
                                    </a>
                                    <a class="save_style" href="#">
                                        Save Styles
                                    </a>
                                </div>
                            </div>
                            <div class="style-toggle open">
                                <i class="fa fa-cog fa-spin"></i>
                            </div>
                        </div>
                        <!-- end: STYLE SELECTOR BOX -->
                        <!-- start: PAGE TITLE & BREADCRUMB -->
                        <ol class="breadcrumb">
                            <li>
                                <i class="clip-file"></i>
                                <a href="home">
                                    Home
                                </a>
                            </li>
                            <li class="active" id="TituloPagNav">
                                Blank Page
                            </li>
                            <li class="search-box ocultar">
                                <form class="sidebar-search">
                                    <div class="form-group">
                                        <input type="text" placeholder="Start Searching...">
                                        <button class="submit">
                                            <i class="clip-search-3"></i>
                                        </button>
                                    </div>
                                </form>
                            </li>
                        </ol>
                        <div class="page-header">
                            <h1 id="TituloPag">Blank Page </h1>
                        </div>
                        <!-- end: PAGE TITLE & BREADCRUMB -->
                    </div>
                </div>