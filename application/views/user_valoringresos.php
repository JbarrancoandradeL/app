<link href="<?php echo base_url() ?>bower_components/datatables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />

<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.maskMoney.js"></script>

    <?php
        if($vista_actual == "ingresos"){
            $readonly_ingreso =  "";
            $readonly_ingreso_ad =  "readOnly";
            $ocultar_ingreso = "";
            $ocultar_ingreso_ad = "ocultar";
            $titulo_paginacion = "Ingresos";
        }else{
            $readonly_ingreso =  "readOnly";
            $readonly_ingreso_ad =  "";
            $ocultar_ingreso = "ocultar";
            $ocultar_ingreso_ad = "";
            $titulo_paginacion = "Ingresos adicionales";
        }
    ?>
<div class="panel panel-default">                          
    <div class="panel-body">                                                           
        <div class="col-sm-6"> <h3>Ingresos Activos</h3>
            <form id="frmDatos">
                <?php foreach ($tipos_ingresos as $key => $value) { 
                        if($value['tipo'] == 'A'){
                ?>     
                         
                    <label for="ing_<?php echo $value['codigo']; ?>">
                        <?php
                        
                        if($vista_actual == "ingresos"){
                            $valor_moneda =  "";
                        }else{
                            $valor_moneda =  " <small>(Actual: "."$ ".number_format( $value['valor'],2).")</small>";
                        }                        

                        $cadena = $value['nombre'].$valor_moneda; 
                        $valor = "$ ".number_format( $value['valor'],2);
                        $valor_adicional = "$ ".number_format($value['valor_adicional'],2);
                        //  $valor = $value['valor'];
                        // $valor_adicional =$value['valor_adicional'];
                        echo $cadena; 
                        $codigo = $value['codigo'];

                        ?>
                    </label>
                    <input type="hidden" value="<?php echo $value['codigo']; ?>" id="<?php echo $value['codigo']; ?>">
                    <div>
                        <input type="text"   style="text-align: right;" value="<?php echo $valor; ?>" <?php echo $readonly_ingreso; ?> class="form-control currency <?php echo $ocultar_ingreso; ?>" id="ing_<?php echo $value['codigo']; ?>" >                        
                        
                    </div>
                    <div>
                        <input type="text"  style="text-align: right;" value="<?php echo $valor_adicional; ?>"  <?php echo $readonly_ingreso_ad; ?> class="form-control currency <?php echo $ocultar_ingreso_ad; ?>" id="ing_ad_<?php echo $value['codigo'];?>">
                    </div>
                <?php 
                        }
                    } 
                ?>                  
            </form>        
        </div>
        <div class="col-sm-6"> <h3>Ingresos Pasivos</h3>
            <form id="frmDatos">
                <?php foreach ($tipos_ingresos as $key => $value) { 
                        if($value['tipo'] == 'P'){
                ?>     
                         
                    <label >
                        <?php
                            if($vista_actual == "ingresos"){
                                $valor_moneda =  "";
                            }else{
                                $valor_moneda =  " <small>(Actual: "."$ ".number_format( $value['valor'],2).") </small>";
                            }
                            
                            $cadena = $value['nombre'].$valor_moneda; 
                            echo $cadena; 
                            $valor = "$ ".number_format( $value['valor'],2);
                            $valor_adicional = "$ ".number_format($value['valor_adicional'],2);
                            // $valor = $value['valor'];
                            // $valor_adicional =$value['valor_adicional'];
                        ?>
                        
                    </label>
                    <input type="hidden" value="<?php echo $value['codigo']; ?>" id="<?php echo $value['codigo']; ?>">
                    <div>
                        <input type="text" style="text-align: right;" value="<?php echo $valor; ?>" <?php echo $readonly_ingreso; ?> class="form-control currency <?php echo $ocultar_ingreso; ?>" id="ing_<?php echo $value['codigo']; ?>">
                    </div>
                    <div>
                        <input type="text" style="text-align: right;" value="<?php echo $valor_adicional; ?>"  <?php echo $readonly_ingreso_ad; ?> class="form-control currency <?php echo $ocultar_ingreso_ad; ?>" id="ing_ad_<?php echo $value['codigo'];?>">
                    </div>
                    
                <?php 
                        }
                    } 
                ?>
            </form>        
        </div>
        <div>

            <table style="width: 100%">
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align: center;"> 
                        <button id="btn_save" onclick="save_valores_ingresos()" data-style="expand-right" class="btn btn-success ladda-button">
                        <span class="ladda-label"> Guardar </span>
                        <i class="glyphicon glyphicon-log-in"></i>    
                        <span class="ladda-spinner"></span>
                        <span class="ladda-spinner"></span>
                        </button>
                    </td>
                </tr>
            </table>
         </div>
    </div>
</div>

<script src="<?php echo base_url() ?>bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>bower_components/datatables/media/js/dataTables.bootstrap.js"></script>

<!-- Scrips que cambian el titulo general de la página -->
<script type="text/javascript"> 
    $("#TituloPagNav").html("<?php echo $titulo_paginacion; ?>");
    $("#TituloPag").html("Simulador flujo de dinero<small> Anotar mis Ingresos <?php if($vista_actual == "ingresos_ad") echo "Adicionales"; ?> </small>");   
</script>
<script type="text/javascript">
       
    $(".currency").maskMoney({prefix:'$ ', allowNegative: true, thousands:',', decimal:'.', affixesStay: true});
    

  function save_valores_ingresos (argument) {      
        var par = ""; 
        var valor = "";
        var valor_adicional = "";
        var RE = /^\d*(\.\d{1})?\d{0,1}$/;
        
        var bandera_salida = true;  
        var array_save = new Array();

        $(":input[type=hidden]").each(function(){  
            var codigo_ingreso =  $(this).attr('id');     
                
            valor = $("#ing_" + codigo_ingreso).maskMoney('unmasked')[0];
            valor_adicional = $("#ing_ad_" + codigo_ingreso).maskMoney('unmasked')[0];
            
            if (!RE.test(valor)) {                
                $("#ing_" + codigo_ingreso).notify("DEBE SER UN DATO NUMERICO MAXIMO DOS DECIMALES", "error");
                $("#ing_" + codigo_ingreso).focus();
                bandera_salida = false;
            }else if(!RE.test(valor_adicional)){
                $("#ing_ad_" + codigo_ingreso).notify("DEBE SER UN DATO NUMERICO MAXIMO DOS DECIMALES", "error");
                $("#ing_ad_" + codigo_ingreso).focus();
                bandera_salida = false;
            }
            
            var temp = new Array(codigo_ingreso, valor, valor_adicional); 
            array_save.push(temp);
        });
       
        if(!bandera_salida) return 0;
            

            $.ajax({
                type: "POST",
                url: "save_valores_ingresos_usuario",
                data: {datos_save : array_save},
                dataType: "json",
                cache: false,            
                success: function (result) {
                    // console.log(result);
                    // return 0;
                   if(result) {                    
                        $.notify("INGRESOS GUARDADOS CON ÉXITO", "success");
                   } else {
                        $.notify("OCURRIÓ UN ERROR AL GUARDAR INGRESOS", "error");
                   }                   
                }

            });      
  }


</script>
