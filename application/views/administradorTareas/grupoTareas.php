<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary" data-collapsed="0"> 
			<div class="panel-heading">
				<div class="panel-title"><h3><center>Grupo de tareas</center></h3></div>
				<div class="panel-options">
				  	 <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				  	  <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> 
				</div>
			</div> 
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-6"> 
						<div class="invoice-left">
						crea una nueva lista de tareas o edita una anterior
						</div>
					</div>
					<div class="col-sm-6"> 
						<div class="invoice-right" style="text-align: right;">
							<a href="<?php echo base_url()?>grupo-tareas/nuevo-grupo" class="btn btn-info btn-icon icon-left">
							nuevo grupo de tareas
							<i class="entypo-list-add"></i> 
							</a>
						</div>
					</div>
				</div>
				<div class="row"><div class="col-md-12"><div style="height: 50px;"></div></div></div>
				<div class="row">
					<div class="col-md-12">
						<table class="getGrupoTareas table" id="getGrupoTareas">
							<caption style="text-align: left;"><h3>Lista de tareas</h3></caption>
							<thead>
								<tr>
									<th>Identificador</th>
									<th>Nombre tarea</th>
									<th>Fecha creación</th>
									<th>Opciones</th>
								</tr>
							</thead>
							<tbody>
							<?php
							if(count($tareas)>0){
								foreach ($tareas as $key => $value){?>
								<tr>
									<td><?php echo $value['NUMERO_PLANTILLA'];?></td>	
									<td><?php echo $value['NOMBRE_TAREA'];?>    </td>	
									<td><?php echo $value['FECHA'];?>           </td>	
									<td>
									<a href="<?php echo base_url().'grupo-tareas/enviar-tareas/'.$value['NUMERO_PLANTILLA'];?>">
										<button class="btn btn-primary popover-primary" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Aquí podrás enviar las tareas a los colaboradores" data-original-title="Información">seleccionar</button>
									</a>
									||
									</td>          
								</tr>
								<?php
								}
							}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<style type="text/css" media="screen">
	.control-label >b{
		color: black;
	}
	#table-1_wrapper{
		overflow-x: auto;
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
				tableContainer = $("#getGrupoTareas");
				
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
</script>


