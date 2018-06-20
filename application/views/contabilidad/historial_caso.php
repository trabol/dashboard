<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style type="text/css" media="screen">
	.link1{
		cursor: pointer;
	}
	.error{
		color: red;
		font-weight: bold;
	}
	.control-label >b{
		color: black;
	}

</style>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary" data-collapsed="0"> 
			<div class="panel-heading">
				 <div class="panel-title"><h3><center>Historial casos</center></h3></div>
				 <div class="panel-options">
				  	 <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				  	  <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> 
				 </div>
			</div>
			
		 	<div class="panel-body">
		 		<div class="row">
					<div class="col-md-12">
						<div class="alert alert-info"><strong>Info: </strong>
							Este administrador te permite visualizar los que has respondido
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<form role="form" class="form-horizontal form-groups-bordered" method="POST" action="<?php echo base_url()?>contabilidad/historial-casos">
			 		 		<div class="form-group" id="grupoFecha">
								<label for="field-1" class="col-sm-3 control-label"><b>Seleccionar Estados</b></label>
								<div   class="col-sm-5">
									<select  class="form-control" id="inputOpciones" name="inputOpciones">
										<option <?php if($inputOpciones=="D"){ echo 'selected';}?> value="D">Devueltos</option>
										<option <?php if($inputOpciones=="A"){ echo 'selected';}?> value="A">Autorizados</option>
									</select>
								</div>
			 		 		</div>	
			 		 		<div class="form-group">
	 		 					<label for="field-2" class="col-sm-3 control-label"><b>Opciones</b></label>
	 		 					<div class="col-sm-2">
	 		 						<input type="submit" class="btn btn-info" id="btnBuscar"  value="Buscar">
	 		 					</div> 
	 		 				</div>
			 		 	</form>	
					</div>
				</div>

				<?php
			 	if(count($casos)>0): ?>
				<table class="table table-bordered datatable" id="table-1">
	 		    	<thead>
		 		    	<tr>
		 		    		<th>Número caso</th>
		 		    		<th>Sociedad</th>
		 		    		<td>Estado</td>
		 		    		<td>comentarios</td>
		 		    		<td>Respondido por</td>
		 		    		<td>Fecha de envio</td>
		 		    		<th>Opciones</th>
		 		    	</tr>
	 		    	</thead>
	 		    	<?php foreach ($casos as $key => $value): 
	 		    		$estado = "Enviado";
	 		    		if($value["ESTADO"]=="D"){
	 		    			$estado ="Devuelto";	
	 		    		}
	 		    		?>
		 		    	<tr>
							<td><?php  echo $value['NUMERO_CASO'];?></td>
							<td><?php  echo $value['EMPRESA'];?></td>
							<td><?php  echo $estado;?></td>
							<td><?php  echo $value['COMENTARIOS'];?></td>
							<td>
								<?php  
									echo $value['RESPONDIDO'][0]["USR_FIRSTNAME"]." ".$value['RESPONDIDO'][0]["USR_LASTNAME"];
								?>
							</td>
							<td> <?php echo $value['FECHA'];?></td>
							<td>
								<a href="<?php echo base_url()?>contabilidad/historial-casos/<?php echo $value['NUMERO_CASO'].'/'.$value['EMPRESA'];?>">
								<button class="btn btn-success">Ver detalles</button>
								</a>
							</td>
		 		    	</tr>
	 		    	<?php endforeach;?>
	 		    </table>
				<?php endif;?>
			</div> 
		</div>
	</div>
</div>
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

var $ = jQuery;

</script>
