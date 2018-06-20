<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary" data-collapsed="0"> 
			<div class="panel-heading">
				<div class="panel-title"><h3><center>Lista de empresas</center></h3></div>
				<div class="panel-options">
				  	 <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				  	  <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> 
				</div>
			</div> 
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-6"> 
						<div class="invoice-right" style="text-align: left;">
							<a href="<?php echo base_url()?>empresas/nueva" class="btn btn-info btn-icon icon-left">
							Agregar nueva empresa
							<i class="entypo-list-add"></i> 
							</a>
						</div>
					</div>
					<div class="col-sm-6"> 
					</div>
				</div><br>
				<div class="row">
					<div class="col-md-12">
						<form method="POST" action="<?php echo base_url();?>empresas/eliminar">
							<table class="getGrupoTareas table" id="getGrupoTareas">
								<caption style="text-align: left;"><h3></h3></caption>
								<thead>
									<tr>
										<th>N°</th>
										<th>Nombre empresa</th>
										<th>Codigo</th>
										<th>Fecha</th>
										<th style="text-align: center;">Opciones</th>
									</tr>
								</thead>
								<tbody>
								<?php
								if(count($empresas)>0){
									foreach ($empresas as $key => $value){?>
									<tr>
										<td><?php echo $value['ID'];?></td>	
										<td><?php echo $value['NOMBRE'];?></td>	
										<td><?php echo $value['CODIGO'];?></td>
										<td><?php echo $value['FECHA'];?></td>	
										<td align="center">
										<a href="<?php echo base_url().'empresas/editar/'.$value['ID'];?>">
											<button type="button" class="btn btn-success popover-success" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Aquí podrás editar Información de la empresa" data-original-title="Información">Modificar</button>
										</a>
										||
										<button type="button" class="btn btn-danger btn_borrar"  id="<?php echo $value["ID"];?>">
										Eliminar</button>

										</td>          
									</tr>
									<?php
									}
								}
								?>
								</tbody>
							</table>
							<input type="hidden" id="hidden_emp_id" value="" name="hidden_emp_id">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-1">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Mensaje confirmación</h4>
			</div>
			
			<div class="modal-body">
				<h2><b>¿Estas seguro de que quieres eliminar esta empresa?</b></h2>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-info" id="modal_confirmacion">Aceptar</button>
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

$(".btn_borrar").click(function(event) {
	/* Act on the event */
	$('#modal-1').modal('show');
	var ID_EMP = $(this).attr("ID");
	$("#hidden_emp_id").val(ID_EMP);
});

$("#modal_confirmacion").click(function(event) {
	/* Act on the event */
	$("form").submit();
});
</script>


