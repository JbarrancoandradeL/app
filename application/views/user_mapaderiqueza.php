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

                                        <a  href="user_mapaderiquezaPDF" download="mapaderiqueza"><button class="btn btn-green ladda-button" > <span class="ladda-label">PDF</span>
                                        <i class="fa fa-file-pdf-o"> </i>
                                        </button> </a>
                                    </th>
                                    <th style="text-align: right; width: 200px">MAPA DE RIQUEZA</th>                                    
                                </tr>
                            </thead>
                            <tbody>                                                                           
                            </tbody>
                        </table>
                        <div >

                        <table class="table table-striped table-hover" id="sampleT">
                            <thead>
                                <tr >
                                    <th >ACTIVO</th>                                    
                                    <th style="text-align: right; width: 200px">VALOR</th>                                    
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $total_activos = 0;
                                    
                                    foreach ($categoria_activos as $key => $value) {
                                            $nombre_categoria_act = $value['nombre'];
                                            
                                            $total_valor = $value['activos'][0]['suma_valores'];
                                            $total_activos += $total_valor;

                                            $total_valor_moneda =  "$ ".number_format($total_valor,2);
                                            
                                
                                ?>
                                <tr>
                                    <td><?php  echo $nombre_categoria_act; ?></td>
                                    <td style="text-align: right;"><?php  echo $total_valor_moneda; ?></td>       
                                </tr>
                                 
                                <?php 
                                    }                                                                                                     

                                    $total_activos_moneda = "$ ".number_format($total_activos,2);                                    
                                    
                                 ?>    
                               
                                <tr style="background-color: #e6e6e6;">
                                    <td>TOTAL ACTIVOS</td>
                                    <td style="text-align: right;"><?php  echo $total_activos_moneda; ?></td>
                                                                               
                                </tr>
                                                                            
                            </tbody>
                        </table>
                        <table class="table table-striped table-hover" id="sampleT">
                            <thead>
                                <tr >
                                    <th>PASIVOS</th>
                                    <th style="text-align: right; right; width: 200px">VALOR</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $total_deudas = 0;
                                    
                                    foreach ($deudas_usuarios as $key => $value) {
                                            
                                            $tipo_deuda = $value['tipo_deuda'];
                                            $total_valor = $value['total'];
                                            $total_deudas += $total_valor;
                                            $total_valor_moneda =  "$ ".number_format($total_valor,2);
                                ?>
                                <tr>
                                    <td>INGRESO <?php  echo $tipo_deuda; ?></td>                                    
                                    <td style="text-align: right;"><?php  echo $total_valor_moneda; ?></td>                                                
                                </tr>
                                 <?php 
                                    }
                                     
                                    
                                    $total_deudas_moneda = "$ ".number_format($total_deudas,2);                                    
                                    
                                    $mapa_neto = $total_activos - $total_deudas;
                                    $mapa_neto_moneda = "$ ".number_format($mapa_neto,2);

                                 ?>                                   
                                <tr style="background-color: #e6e6e6;">
                                    <td>TOTAL PASIVOS</td>
                                    <td style="text-align: right;"><?php  echo $total_deudas_moneda ?></td>
                                                                                  
                                </tr>
                                 <tr>
                                    <td> </td>
                                    <td> </td>
                                                                  
                                </tr> 
                                <tr style="background-color: #e6e6e6;">
                                    <td>RIQUEZA NETA</td>
                                    <td style="text-align: right;"><?php  echo $mapa_neto_moneda; ?></td>                  
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
