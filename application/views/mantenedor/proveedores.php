<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style type="text/css" media="screen">
	.link1{
		cursor: pointer;
	}
	.dataTables_wrapper{
		overflow-x: scroll!important;
	}
</style>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary" data-collapsed="0"> 
			<div class="panel-heading">
				 <div class="panel-title"><h3><center>Proveedores ISAPRES</center></h3></div>
				 <div class="panel-options">
				  	 <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				  	  <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> 
				 </div>
			</div>
			
		 	<div class="panel-body">
		 	    <div class="row">
		 	    	<div class="col-md-10">
						<div class="alert alert-info"><strong>Info: </strong>
							Este administrador te permite  ver a los proveedores y sus cuentas.
						</div>
					</div>
		 	    	<div class="col-md-2">
		 	    		<a href ="<?php echo base_url()?>mantenedor/proveedores/nuevo">
		 	    			<button class="btn btn-success pull-right">Nuevo proveedor</button>
		 	    		</a>
		 	    	</div>
		 	    </div>
		 	    <?php if(count($proveedores) >0 ){?>
		 	    <div class="row">
		 	    	<div class="col-md-12">
		 	    		<div class="panel panel-gradient" id="tabFormuario1">
						<div class="panel-heading">
							<div class="panel-title"><h4><b></b></h4></div>
							<div class="panel-options">
								<ul class="nav nav-tabs">
								    <?php $x =1;
								    foreach ($proveedores as $key => $value){ 
								    	$active ="";
								    	if($x==1){ $active = "active";} 
								    	$empresa ="Isapre Banmedica";
								    	if($x ==2){ $empresa ="Vida Tres";}
								    	?>
								    	
									<li class="<?php echo $active?>">
										<a href="#profile-<?php echo $x;?>" data-toggle="tab">
											<?php echo $empresa;?>
										</a>
									</li>
								    <?php $x++; } ?>

								</ul>
							</div>
						</div>
						<div class="panel-body">
						<div class="tab-content" >
						<?php $y =1;
							foreach ($proveedores as $key => $value){ 
								$active2 ="";
								$color ="info";
								if($y==1){ $active2 = "active"; $color ="primary";}
								?>
								<div class="tab-pane <?php echo $active2;?>" id="profile-<?php echo $y;?>">
									<table class="table table-bordered datatable" id="table-<?php echo $y;?>">
										<thead>
										<tr>
											<th>Sociedad</th>
											<th>RUT</th>
											<th>NOMBRE</th>
											<th>CORREO</th>
											<th>BCO_PROPIO</th>
											<th>AGENCIA</th>
											<th>TIPO_PAGO</th>
											<th>CANT. CUENTAS</th>
											<th>OPCIONES</th>
										</tr>
										</thead>
										<?php foreach ($value as $v){
											$formaPago ="CHEQUE";
											if(trim($v->TIPO_PAGO)=="V"){
												$formaPago ="VALE VISTA";
											}
											if(trim($v->TIPO_PAGO)=="T"){
												$formaPago ="TRANSFERENCIA";
											}

											$colorCuentas ="info";
											$NUM_CUENTAS  =$v->NUM_CUENTAS;
											if(trim($v->NUM_CUENTAS)==0){
												$colorCuentas ="danger";
												$NUM_CUENTAS  ="SIN CUENTAS";
											}

											?>										
										<tr>
											<td><span class="label label-<?php echo $color;?>">
												<b><?php echo $v->SOCIEDAD;?></b></span>
											</td>
											<td><?php  echo $v->RUT;?></td>
											<td><?php  echo $v->NOMBRE;?></td>
											<td><?php  echo $v->EMAIL;?></td>
											<td><?php  echo $v->BCO_PROPIO;?></td>
											<td><?php  echo $v->AGENCIA;?></td>
											<td><?php  echo $formaPago;?></td>

											<td>
											<span class="label label-<?php echo $colorCuentas;?>" style="text-align: left;">
											<?php echo $NUM_CUENTAS;?>
											</span>
											</td>

											<td>
												<a href="<?php base_url();?>proveedores/editar/<?php echo $v->RUT;?>_<?php echo $v->SOCIEDAD;?>">
													<button class="btn btn-success">EDITAR</button>
												</a>
											</td>
										</tr>
										<?php } ?>
									</table>
								</div>
						<?php $y++; }?>
						</div>
						</div>
					</div>
		 	    	</div>
		 	    </div>
		 	    <?php }?>
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


		var responsiveHelper2;
		var breakpointDefinition2 = {
		    tablet: 1024,
		    phone : 480
		};
		var tableContainer2;
		
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
				/************************************************************************************/
				tableContainer2 = $("#table-2");
				
				tableContainer2.dataTable({
					"sPaginationType": "bootstrap",
					"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
					"bStateSave": true,
					
		
				    // Responsive Settings
				    bAutoWidth     : false,
				    fnPreDrawCallback: function () {
				        // Initialize the responsive datatables helper once.
				        if (!responsiveHelper2) {
				            responsiveHelper2 = new ResponsiveDatatablesHelper(tableContainer2, breakpointDefinition2);
				        }
				    },
				    fnRowCallback  : function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
				        responsiveHelper2.createExpandIcon(nRow);
				    },
				    fnDrawCallback : function (oSettings) {
				        responsiveHelper2.respond();
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
