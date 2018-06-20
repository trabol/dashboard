<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style type="text/css" media="screen">
	.link1{
		cursor: pointer;
	}
</style>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary" data-collapsed="0"> 
			<div class="panel-heading">
				 <div class="panel-title">
				 	<h3>
				 	<center>Cargar Distribución / Plantillas</center>
				 	</h3>
				 </div>
				 <div class="panel-options">
				  	 <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				  	  <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> 
				 </div>
			</div>
		 	<div class="panel-body">
		 	    <div class="row">
					<div class="col-md-10">
						<div class="alert alert-info"><strong>Info: </strong>
							Este administrador te permite editar y borrar las plantillas que uses, para cargar las distribucion de costos de manera automática.
						</div>
					</div>
					<div class="col-md-2">
		 	    		<a href ="<?php echo base_url()?>mantenedor/cargar-distribucion/nuevo">
		 	    			<button class="btn btn-success pull-right">
		 	    			<i class="entypo-list-add"></i>
		 	    			Nueva Planilla
		 	    			</button>
		 	    		</a>
		 	    	</div>
				</div>
				<table class="table table-bordered datatable" id="table-1">
	 		    	<thead>
		 		    	<tr>
		 		    		<th>Rut proveedor</th>
		 		    		<th>Nombre Proveedor</th>
		 		    		<th>numero cliente</th>
		 		    		<th>Descripción</th>
		 		    		<td>Opciones</td>
		 		    	</tr>
	 		    	</thead>
	 		    	<tbody>
		 		    	<tr>
							<td>76083683-4</td>
							<td>A Y B INGENIERIA Y CONSTRUCCION LIM</td>
							<td>76083683</td>
							<td>Soló para facturas electrónicas</td>
							<td>
								<a href="http://172.31.100.78:81/dashboard/mantenedor/cargar-distribucion/editar">
								<button class="btn btn-primary">Actualizar</button></a>
								|| 
							    <button class="btn btn-danger">Eliminar</button> 
							</td>
		 		    	</tr>
		 		    	<tr>
							<td>96919050-8</td>
							<td>ACEPTA.COM S.A.</td>
							<td>96919050</td>
							<td>Sin descripción</td>
							<td>
								<a href="http://172.31.100.78:81/dashboard/mantenedor/cargar-distribucion/editar">
								<button class="btn btn-primary">Actualizar</button></a>
								|| 
							    <button class="btn btn-danger">Eliminar</button>
							</td>
		 		    	</tr>
		 		    	<tr>
							<td>7277253-9</td>
							<td>ADIS PINILLA GONZALEZ</td>
							<td>7277253</td>
							<td>Districión para los pagos de Viña</td>
							<td>
								<a href="http://172.31.100.78:81/dashboard/mantenedor/cargar-distribucion/editar">
								<button class="btn btn-primary">Actualizar</button></a>
								|| 
							    <button class="btn btn-danger">Eliminar</button>
							</td>
		 		    	</tr>
		 		    	<tr>
							<td>76949270-4</td>
							<td>BESTWAY</td>
							<td>7277253</td>
							<td>Districión para los pagos de Viña</td>
							<td>
								<a href="http://172.31.100.78:81/dashboard/mantenedor/cargar-distribucion/editar">
								<button class="btn btn-primary">Actualizar</button></a>
								|| 
							    <button class="btn btn-danger">Eliminar</button> 
							</td>
		 		    	</tr>
		 		    </tbody>
	 		    </table>
		 	   
			</div>
		</div>
	</div>
	<input type="hidden" id="hiddenRUT" value="<?php echo $getRUT;?>">
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
		jQuery("#table-1_filter input").attr("id","seachID");
		jQuery("#table-1_filter input").val(jQuery("#hiddenRUT").val());
		
	});

var $= jQuery;

setTimeout(function() {
	document.getElementById("seachID").addEventListener("click", function(ev){
		console.log(ev);
		var e = new Event('keydown');
		e.which = e.keyCode = 32; // 32 is the keycode for the space bar	
		
		var cb = document.getElementById("seachID"); 
				 cd.dispatchEvent(e); 
	});

	$("#seachID").trigger('click');
}, 100);


</script>