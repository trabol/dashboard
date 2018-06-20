<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style type="text/css" media="screen">
	.link1{
		cursor: pointer;
	}
</style>
<!--<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary" data-collapsed="0"> 
			<div class="panel-heading">
				 <div class="panel-title"><h3><center>Usuario BPM</center></h3></div>
				 <div class="panel-options">
				  	 <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				  	  <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> 
				 </div>
			</div>
		 	<div class="panel-body">
				<div class="row">
					<div class="col-sm-3"> 
						<a href="<?php echo base_url();?>mantenedor/usuarios-bpm/new">
							<div class="tile-title tile-blue link1">
								<div class="icon"> <i class="glyphicon glyphicon-user"></i></div>
								<div class="title"> 
									<h3>crear</h3><p>Nuevos usuarios</p>
								</div> 
							</div>
						</a> 
					</div>
				</div>
			</div>
		</div>
	</div>
</div>-->

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary" data-collapsed="0"> 
			<div class="panel-heading">
				 <div class="panel-title"><h3><center>Lista de usuarios:ISAPRES</center></h3></div>
				 <div class="panel-options">
				  	 <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				  	  <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> 
				 </div>
			</div>
			
		 	<div class="panel-body">
		 		<div class="row">
					<div class="col-md-12">
						<div class="alert alert-info"><strong>Info: </strong>
							Este administrador te permite editar y borrar los usuarios del bpm.
						</div>
					</div>
				</div>
				<?php
			 	if(count($usuarios)>0): ?>
				<table class="table table-bordered datatable" id="table-1">
	 		    	<thead>
		 		    	<tr>
		 		    		<th>Usuario</th>
		 		    		<th>Rut</th>
		 		    		<th>Nombre</th>
		 		    		<th>e-mail</th>
		 		    		<th>Opciones</th>
		 		    	</tr>
	 		    	</thead>
	 		    	<?php foreach ($usuarios as $key => $value): ?>
		 		    	<tr>
							<td><?php  echo $value['LOGIN'];?></td>
							<td><?php  echo $value['RUT'];?></td>
							<td><?php  echo $value['USR_FIRSTNAME']." ".$value['USR_LASTNAME'];?></td>
							<td><?php  echo $value['USR_EMAIL'];?></td>
							<td><a href="<?php echo base_url().'mantenedor/usuarios-bpm/'.$value['USER_UID'];?>"><button class="btn btn-success">Modificar</button></a></td>
		 		    	</tr>
	 		    	<?php endforeach;?>
	 		    </table>
				<?php endif;?>
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
</script>
