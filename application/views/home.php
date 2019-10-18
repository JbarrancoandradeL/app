<div class="row">
    <div class="col-sm-6 center" style="background-color:#ffffff;  ">
        <div class="panel-body"> 
            <img width= 1050px height= 350px alt="" src="<?php echo base_url() ?>img/logoBase.png">                   
        </div>
    </div>
</div>
<!-- Scrips que cambian el titulo general de la página -->
<script type="text/javascript"> 
    $("#TituloPagNav").html("");
    $("#TituloPag").html("MasterMind<small> Lideres Extraordinarios</small>");
</script>
<!-- scripts que controla  -->


<?php 


 $codigo_perfil = $this->session->userdata('codigo_perfil');
 

     ?>