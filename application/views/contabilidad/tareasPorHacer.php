<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style type="text/css" media="screen">
	.link1{
		cursor: pointer;
	}
	.error{
		color: red;
		font-weight: bold;
	}

</style>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary" data-collapsed="0"> 
			<div class="panel-heading">
				 <div class="panel-title"><h3><center>Casos pendientes</center></h3></div>
				 <div class="panel-options">
				  	 <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				  	  <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> 
				 </div>
			</div>
			
		 	<div class="panel-body">
		 		<div class="row">
					<div class="col-md-12">
						<div class="alert alert-info"><strong>Info: </strong>
							Este administrador te permite devolver o aprobar los casos enviados por los colaboradores
						</div>
					</div>
				</div>
				<?php  if(count($casos)==0){?>
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-warning"><strong>Info: </strong>
							No tiene casos asignados
						</div>
					</div>
				</div>
				<?php }?>
				
				<?php
				$PRONTO_PAGO_CANT =0;

			 	if(count($casos)>0):?>
				<table class="table table-bordered datatable" id="table-1">
	 		    	<thead>
		 		    	<tr>
		 		    		<th>Número caso</th>
		 		    		<th>Ultima actualización</th>
		 		    		<th>Sociedad</th>
		 		    		<th>Número Doc</th>
		 		    		<th>Fecha emisión doc</th>
		 		    		<th>Proveedor</th>
		 		    		<th>Pronto Pago</th>
		 		    		<th>Ingresado Por</th>
		 		    		<th>Reclamado Por</th>
		 		    		<th>Opciones</th>
		 		    	</tr>
	 		    	</thead>
	 		    	<?php foreach ($casos as $key => $value): ?>
		 		    	<tr>
							<td><?php  echo $value['caso'];?></td>
							<td><?php  echo $value['DEL_DELEGATE_DATE'];?></td>
							<td><?php  echo $value['empresa'];?></td>
							<td><?php  echo $value['num_dt'];?></td>
							<td><?php  echo $value['fecha'];?></td>
							<td><?php  echo $value['Proveedor'];?></td>
							<td><?php  echo $value['PRONTO_PAGO'];?></td>
							<td><?php  echo $value['Solicitante'];?></td>
							<td>
							<?php
								if(isset($value['DELEGADO_A'][0]["USR_FIRSTNAME"])){
									echo $value['DELEGADO_A'][0]["USR_FIRSTNAME"]." ".$value['DELEGADO_A'][0]["USR_LASTNAME"];
									$ID_ASIG = $value['DELEGADO_A'][0]["USR_UID"];
									$boton ="ver caso";
									$btn   ="btn-success";
								}else{
									echo "<h5 class='error'>Sin Asignación</h5>";
									$ID_ASIG ="";
									$boton ="Reclamar caso";
									$btn   ="btn-danger";
								}
							?>
							</td>
							<td>
								<button  class="btn <?php echo $btn;?>  BTN_VER_CASO" EMP_CASO="<?php echo $value["empresa"];?>" NU_CASO="<?php echo $value['caso']?>" ID_ASIG="<?php echo $ID_ASIG?>">
								<?php echo $boton;?>
									
								</button>
								
							</td>
		 		    	</tr>
	 		    	<?php
	 		    		if($value["ACTIVO_NOTICACION"]=="SI"){
	 		    			$PRONTO_PAGO_CANT = $PRONTO_PAGO_CANT+1;
	 		    		}
	 		    	 endforeach;?>
	 		    </table>
				<?php endif;?>
			</div> 
		</div>
	</div>
</div>

<?php 
$ACTIVO_NOTICACION ="NO";
$ca ="caso";
$pe ="PENDIENTE";
$MensajePRONTO ="nada";
if($PRONTO_PAGO_CANT > 0){
    if($PRONTO_PAGO_CANT > 1){
   		$ca ="casos";
   		$pe ="PENDIENTES";
    }
    $ACTIVO_NOTICACION = "SI";
    $MensajePRONTO = $_SESSION['SE_NOMBRE'].' actualmente tienes '.$PRONTO_PAGO_CANT.' '.$ca.' <b>'.$pe.'</b> que corresponde ha un <b>Pronto Pago</b>, favor de revisar lo antes posible.';
}
?>
<input type="hidden" value="<?php echo $ACTIVO_NOTICACION;?>" id="ACTIVO_NOTICACION">

<div class="modal fade" id="modalMensajeError">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Mensaje de alerta</h4>
			</div>
			<div class="modal-body">
				<h2><b>Este caso ha sido reclamado por otro usuario del grupo</b></h2>
				<label>
					Enviar una solicitud a informatica para volver a reclamar el caso</label>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">salir</button>
			</div>
		</div>
	</div>
</div>
<style type="text/css" media="screen">
	.control-label >b{
		color: black;
	}
</style>	
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/datatables/responsive/css/datatables.responsive.css">
<script src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/js/datatables/TableTools.min.js"></script>
<script src="<?php echo base_url();?>assets/js/datatables/jquery.dataTables.columnFilter.js"></script>
<!-- Imported styles on this page -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/datatables/responsive/css/datatables.responsive.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/select2/select2-bootstrap.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/select2/select2.css">
<!-- Bottom scripts (common) -->
<script src ="<?php echo base_url();?>assets/js/bootstrap-datepicker.js"></script>
<script src ="<?php echo base_url();?>assets/js/bootstrap-timepicker.min.js"></script>
<script src ="<?php echo base_url();?>assets/js/bootstrap-colorpicker.min.js"></script>
<script src ="<?php echo base_url();?>assets/js/daterangepicker/moment.min.js"></script>
<script src ="<?php echo base_url();?>assets/js/daterangepicker/daterangepicker.js"></script>

<script src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/js/datatables/TableTools.min.js"></script>
<!-- Imported scripts on this page -->
<script src="<?php echo base_url();?>assets/js/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url();?>assets/js/datatables/jquery.dataTables.columnFilter.js"></script>
<script src="<?php echo base_url();?>assets/js/datatables/lodash.min.js"></script>
<script src="<?php echo base_url();?>assets/js/datatables/responsive/js/datatables.responsive.js"></script>
<script src="<?php echo base_url();?>assets/js/select2/select2.min.js"></script>
<!-- JavaScripts initializations and stuff -->
<!-- Demo Settings -->

<script type="text/javascript">
    
		var responsiveHelper;
		var breakpointDefinition = {
		    tablet: 1024,
		    phone : 480
		};
		var tableContainer;
		
			jQuery(document).ready(function($)
			{
				tableContainer = $("#table-1");
				
				tableContainer.dataTable({
					"sPaginationType": "bootstrap",
					"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
					"bStateSave": true,
					
		
				    // Responsive Settings
				    bAutoWidth     : false,
				    fnPreDrawCallback: function () {
				        // Initialize the responsive datatables helper once.
				        if (!responsiveHelper) {
				            responsiveHelper = new ResponsiveDatatablesHelper(tableContainer, breakpointDefinition);
				        }
				    },
				    fnRowCallback  : function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
				        responsiveHelper.createExpandIcon(nRow);
				    },
				    fnDrawCallback : function (oSettings) {
				        responsiveHelper.respond();
				    }
				});
				
				$(".dataTables_wrapper select").select2({
					minimumResultsForSearch: -1
				});
	});
</script>
<script type="text/javascript">
var $ = jQuery;

$(document).ready(function() {
	

var ACTIVO_NOTICACION = $("#ACTIVO_NOTICACION").val();



if(ACTIVO_NOTICACION =="SI"){
	var opts = {
	"closeButton": true,
	"debug": false,
	"positionClass": "toast-top-right",
	"onclick": null,
	"showDuration": "15000",
	"hideDuration": "15000",
	"timeOut": "15000",
	"extendedTimeOut": "15000",
	"showEasing": "swing",
	"hideEasing": "linear",
	"showMethod": "fadeIn",
	"hideMethod": "fadeOut"
	};
	toastr.info("<?php echo $MensajePRONTO;?>", null, opts);
}


$(".BTN_VER_CASO").click(function(event) {
	/* Act on the event */
	var ID_ASIG     = $(this).attr("ID_ASIG");
	var NU_CASO     = $(this).attr("NU_CASO");
	var EMP_CASO    = $(this).attr("EMP_CASO");
    

	var url ="<?php echo base_url();?>contabilidad/tarea-por-hacer/editar/"+NU_CASO+"/"+EMP_CASO;
	var sessionUDI = "<?php echo $_SESSION['USR_LOGGED']; ?>";
	
	if(ID_ASIG ==  sessionUDI){
		window.location.href = url;
	}
	else if(ID_ASIG ==""){
		window.location.href = url;
	}
	else
	{
	  $("#modalMensajeError").modal("show");
	}
});

});
</script>
