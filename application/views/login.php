<!DOCTYPE html>
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html class="no-js">
<!--<![endif]-->

<!-- <?php echo base_url() ?> -->

<head>
    <title>S.M. International Group</title>
   
    <meta charset="utf-8" />
   
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="Responsive Admin Template build with Twitter Bootstrap and jQuery" name="description" />
    <meta content="ClipTheme" name="author" />
 
    <link type="text/css" rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700|Raleway:400,100,200,300,500,600,700,800,900/" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>bower_components/bootstrap/dist/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>bower_components/font-awesome/css/font-awesome.min.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/fonts/clip-font.min.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>bower_components/iCheck/skins/all.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>bower_components/sweetalert/dist/sweetalert.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/css/main.min.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>assets/css/main-responsive.min.css" />
    <link type="text/css" rel="stylesheet" media="print" href="<?php echo base_url() ?>assets/css/print.min.css" />
    <link type="text/css" rel="stylesheet" id="skin_color" href="<?php echo base_url() ?>assets/css/theme/light.min.css" />
    <link type="text/css" rel="stylesheet" id="skin_color" href="<?php echo base_url() ?>css/general.css" />
   

</head>

<body class="login example2">

    <div class="main-login col-sm-4 col-sm-offset-4">
        <div class="logo">
            S.M. <i class="clip-clip ocultar"></i>INTERNATIONAL GROUP
        </div>
        <!-- start: LOGIN BOX -->
        <div class="" style="background-color: white; padding: 30px;">

            <h3>Iniciar sesión en su cuenta</h3>

            <p>
                Ingrese su nombre de usuario y contraseña para iniciar sesión.
            </p>

            <form class="form-login" action="#" onsubmit="return validar_login()">
                 
                <fieldset>
                    <div class="form-group">
                        <span class="input-icon">
                            <input value="" type="text" class="form-control" name="usuario_txt" placeholder="Usuario" required="" id="usuario_txt" autofocus="">
                            <i class="fa fa-user"></i>
                        </span>
                    </div>
                    <div class="form-group form-actions">
                        <span class="input-icon">
                            <input value="" type="password" class="form-control password" name="contra_txt" placeholder="Contraseña" required="" id="contra_txt">
                            <i class="fa fa-lock"></i>
                            <a class="forgot ocultar" href="javascript:void(0)" style=" cursor: no-drop;" >
                                Olvidé mi contraseña
                            </a>
                        </span>
                    </div>
                    <div class="form-actions">
                        <label for="remember" class="checkbox-inline ocultar">
                            <input type="checkbox" class="grey remember" id="remember" name="remember">
                            Keep me signed in
                        </label>
                        <button type="submit" class="btn btn-bricky pull-right">
                            Iniciar sesión <i class="fa fa-arrow-circle-right"></i>
                        </button>
                    </div>
                    
                </fieldset>
            </form>
        </div>
     
 
    </div>

    <form action="home" id="go_home" method="POST">
        
    </form>

    <script type="text/javascript">
        
        function validar_login (argument) {


            if($("#usuario_txt").val().trim() == "") {

                $("#usuario_txt").val("");
                $("#usuario_txt").notify("EL NOMBRE DE USUARIO ES REQUERIDO", "error");
                $("#usuario_txt").focus();
            
            } else if($("#contra_txt").val() == "") {
 
                $("#contra_txt").notify("LA CONTRASEÑA ES REQUERIDA", "error");
                $("#contra_txt").focus();    

            } else {

                var par =  "user=" + $("#usuario_txt").val();
                    par += "&contra=" + $("#contra_txt").val();

                $.ajax({
                    type: "POST",
                    url: "validar_login",
                    data: par,
                    dataType: "json",
                    cache: false,
                    
                    success: function (result) { 

                        if(result == 0) { 
                            $.notify("ERROR DE CREDENCIALES DE ACCESO", "error");

                        } else if(result == 1) {

                            
                            $("#go_home").submit();
                        }

                        console.log(result); 

                    }  
                }); 
            } 

            return false;
        }


    </script>


 
    <script type="text/javascript" src="<?php echo base_url() ?>bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>js/notify.min.js"></script>

    <!--<![endif]-->
    <script type="text/javascript" src="<?php echo base_url() ?>bower_components/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>bower_components/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>bower_components/blockUI/jquery.blockUI.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>bower_components/iCheck/icheck.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>bower_components/perfect-scrollbar/js/min/perfect-scrollbar.jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>bower_components/jquery.cookie/jquery.cookie.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>bower_components/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/min/main.min.js"></script>


</body>

</html>