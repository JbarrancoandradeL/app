<link href="<?php echo base_url() ?>bower_components/datatables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />



 <!-- start: PAGE CONTENT -->
    <div class="row">
        <div class="col-md-10">
            <div class="panel ">
                
                <div class="panel-body ">                                
                    <div class="col-md-12">
                          <table class="table table-striped table-hover" id="sampleT">
                            <thead>
                                <tr >
                                    <th >&nbsp; </th>
                                    <th style="text-align: right; width: 200px">&nbsp;</th>
                                    <th style="text-align: right; width: 200px">

                                        <a  href="user_flujodedineroPDF" download="flujodedinero"><button class="btn btn-green ladda-button" > <span class="ladda-label">PDF</span>
                                        <i class="fa fa-file-pdf-o"> </i>
                                        </button> </a>
                                    </th>
                                    <th style="text-align: right; width: 200px">PLAN DE ACCI&Oacute;N</th>                                    
                                </tr>
                            </thead>
                            <tbody>                                                                           
                            </tbody>
                        </table>
                        <div class="scrollDiv">

                        <table class="table table-striped table-hover" id="sampleT">
                            <thead>
                                <tr >
                                    <th >INGRESOS</th>
                                    <th style="text-align: right; width: 200px">INGRESO MENSUAL</th>
                                    <th style="text-align: right; width: 200px">INGRESO ADICIONAL</th>                                    
                                    <th style="text-align: right; width: 200px">LIBERTAD FINANCIERA</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $total_ingresos = 0;
                                    $total_ingresos_ad = 0;
                                    foreach ($ingresos_usuarios as $key => $value) {
                                            
                                            $nombre_ingreso = $value['tipo'];
                                            $total_valor = $value['suma_valores'];
                                            $total_ingresos += $total_valor;

                                            $total_valor_ad = $value['suma_valores_ad'];
                                            $total_ingresos_ad += $total_valor_ad;

                                            $total_valor_lf_ingresos = $total_valor +  $total_valor_ad;

                                            $total_valor_moneda =  "$ ".number_format($total_valor,2);
                                            $total_valor_ad_moneda =  "$ ".number_format($total_valor_ad,2); 
                                            $total_valor_lf_ingresos_moneda =  "$ ".number_format($total_valor_lf_ingresos,2);
                                            


                                
                                ?>
                                <tr>
                                    <td>INGRESO <?php  echo $nombre_ingreso; ?></td>
                                    <td style="text-align: right;"><?php  echo $total_valor_moneda; ?> </td>
                                    <td style="text-align: right;"><?php  echo $total_valor_ad_moneda; ?></td>
                                    <td style="text-align: right;"><?php  echo $total_valor_lf_ingresos_moneda; ?></td>                                                
                                </tr>
                                 <?php 
                                    }
                                     
                                    $total_ingresos_lf = $total_ingresos + $total_ingresos_ad;
                                    $total_ingresos_moneda = "$ ".number_format($total_ingresos,2);                                    
                                    $total_ingresos_ad_moneda = "$ ".number_format($total_ingresos_ad,2);

                                    $total_ingresos_lf_moneda = "$ ".number_format($total_ingresos_lf,2);

                                 ?>                                   
                                <tr style="background-color: #e6e6e6;">
                                    <td>TOTAL INGRESOS</td>
                                    <td style="text-align: right;"><?php  echo $total_ingresos_moneda; ?></td>
                                    <td style="text-align: right;"><?php  echo $total_ingresos_ad_moneda; ?></td>
                                    <td style="text-align: right;"><?php  echo $total_ingresos_lf_moneda; ?></td>                                              
                                </tr>                                           
                            </tbody>
                        </table>
                        <table class="table table-striped table-hover" id="sampleT">
                            <thead>
                                <tr >
                                    <th>EGRESOS</th>
                                    <th style="text-align: right; right; width: 200px">EGRESO MENSUAL</th>
                                    <th style="text-align: right; right; width: 200px">AHORRO HORMIGA</th>
                                    <th style="text-align: right; right; width: 200px">&nbsp;</th>                                                                        
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $total_egresos = 0;
                                    $total_egresos_h = 0;
                                    foreach ($categoria_egresos as $key => $value) {
                                            $nombre_categoria_egr = $value['nombre'];
                                            
                                            $total_valor = $value['egresos'][0]['suma_valores'];
                                            $total_egresos += $total_valor;

                                            $total_valor_h = $value['egresos'][0]['suma_valores_hormiga'];
                                            $total_egresos_h += $total_valor_h;

                                            $total_valor_LFE =  $total_valor - $total_valor_h;

                                            
                                            $total_valor_moneda =  "$ ".number_format($total_valor,2);
                                            $total_valor_h_moneda =  "$ ".number_format($total_valor_h,2);
                                            $total_valor_LFE_moneda =  "$ ".number_format($total_valor_LFE,2);
                                
                                ?>
                                <tr>
                                    <td><?php  echo $nombre_categoria_egr; ?></td>
                                    <td style="text-align: right;">(<?php  echo $total_valor_moneda; ?>)</td>
                                    <td style="text-align: right;"><?php  echo $total_valor_h_moneda; ?></td>
                                    <td style="text-align: right;">(<?php  echo $total_valor_LFE_moneda; ?>)</td>                                                
                                </tr>
                                 
                                <?php 
                                    }
                                    //total_deudas ya viene con valor desde el modulo
                                    $total_egresos += $total_deudas; 
                                    $total_deudas_moneda = "$ ".number_format($total_deudas,2);

                                    $total_LFE = $total_egresos - $total_egresos_h;
                                    $total_LFE_moneda = "$ ".number_format($total_LFE,2);

                                    $total_egresos_moneda = "$ ".number_format($total_egresos,2);                                    
                                    $total_egresos_h_moneda = "$ ".number_format($total_egresos_h,2);

                                    $flujo_neto = $total_ingresos - $total_egresos;
                                    $flujo_neto_moneda = "$ ".number_format($flujo_neto,2);


                                    $meta_plan = $total_ingresos_ad + $total_egresos_h;
                                    $meta_plan_moneda = "$ ".number_format($meta_plan,2);

                                    $total_libertad = $total_ingresos_lf - $total_LFE;
                                    $total_libertad_moneda = "$ ".number_format($total_libertad,2);
                                 ?>    
                                 <tr>
                                    <td>DEUDAS</td>
                                    <td style="text-align: right;">(<?php  echo $total_deudas_moneda; ?>)</td>
                                    <td style="text-align: right;">&nbsp;</td>
                                    <td style="text-align: right;">&nbsp;</td>                                                
                                </tr>
                                <tr style="background-color: #e6e6e6;">
                                    <td>TOTAL EGRESOS</td>
                                    <td style="text-align: right;">(<?php  echo $total_egresos_moneda; ?>)</td>
                                    <td style="text-align: right;"><?php  echo $total_egresos_h_moneda; ?></td>
                                    <td style="text-align: right;">(<?php  echo $total_LFE_moneda; ?>)</td>                                              
                                </tr>
                                <tr>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>                                              
                                </tr> 
                                <tr style="background-color: #e6e6e6;">
                                    <td>FLUJO NETO</td>
                                    <td style="text-align: right;"><?php  echo $flujo_neto_moneda; ?></td>
                                    <td style="text-align: right;"><?php  echo $meta_plan_moneda; ?></td>
                                    <td style="text-align: right;"><?php  echo $total_libertad_moneda; ?></td>                                                                                           
                                </tr>                                             
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        
    </div>
<!-- end: PAGE CONTENT-->
        

<script src="<?php echo base_url() ?>bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>bower_components/datatables/media/js/dataTables.bootstrap.js"></script>
<!-- Scrips que cambian el titulo general de la página -->
  <script type="text/javascript"> 
    $("#TituloPagNav").html("Flujo de dinero - General");
    $("#TituloPag").html("Flujo de dinero<small> Mapa general del flujo de caja </small>");
</script>
