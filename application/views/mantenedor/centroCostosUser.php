<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style type="text/css">
	b{
		color:black;
		font:15px;
	}
	#input_borrar{
		float: right;
		margin-right: 40px;
	}
	.ms-container .ms-list {
		width: 300px!important;		
	}
</style>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary" data-collapsed="0"> 
			<div class="panel-heading">
				 <div class="panel-title"><h3><center>Centro costos </center></h3></div>
				 <div class="panel-options">
				  	 <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				  	  <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> 
				 </div>
			</div> 
		 	<div class="panel-body">
		 		<div class="row">
					<div class="col-md-12">
						<div class="alert alert-info"><strong>Info: </strong>
							Este administrador te permite editar los centro de costos asociados al colaborador.
						</div>
					</div>
					<?php if(isset($borrarEstado) && $borrarEstado==1):?>
					<div class="col-md-12" id="mensaje_borrado">
						<div class="alert alert-success"><strong>Mensaje: </strong>
							Centro de costos eliminados correctamente
						</div>
					</div>
					<?php endif;?>
				</div>
				<div class="row"|>
					<div class="col-md-12">
						<div class="member-entry">
							<a href="#" class="member-img">
								<i class="entypo-forward"></i>
							</a>
							<div class="member-details">
								<h4>
									<a href="#"><?php echo $user[0]->USR_FIRSTNAME." ".$user[0]->USR_LASTNAME;?></a>
								</h4>
								<!-- Details with Icons -->
								<div class="row info-list">
									
									<div class="col-sm-4">
										<i class="entypo-briefcase"></i>
										User login <a href="#"><?php echo $user[0]->USR_USERNAME?></a>
									</div>
									<div class="col-sm-4">
										<i class="entypo-mail"></i>
										<a href="#"><?php echo $user[0]->USR_EMAIL;?></a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="panel panel-danger" data-collapsed="0">
							<div class="panel-heading">
								<div class="panel-title">
									Eliminar centro de costos asociados al usuario
								</div>
								<div class="panel-options">
									<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
									<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
									<a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
								</div>
							</div>
							<div class="panel-body">
								<form  id="form1" role="form" class="form-horizontal form-groups-bordered" method="POST" action="<?php echo base_url();?>mantenedor/centro-costos/<?php echo $user[0]->USR_UID;?>">
									<div class="form-group">
										<label class="col-sm-3 control-label"><b>seleciona un empresa</b></label>
										<div class="col-sm-5"> 
												<select name="input_empresa" class="form-control col-sm-5" id="input_empresa">
				                                <option></option>
												<option <?php if($input_empresa == "CL01"){ echo "selected"; }?> value="CL01">ISAPRE BANMÉDICA</option>
												<option <?php if($input_empresa == "CL24"){ echo "selected"; }?> value="CL24">VIDA TRES</option>
											</select>
										</div> 
									</div>	
									<div class="form-group">
										<label class="col-sm-1 control-label">
											<b>Centro de costos asosiados al usuario</b>
											<i class="entypo-right-bold"></i>
										</label>
										<div class="col-sm-9">
										<select multiple="multiple" name="my_select[]" class="form-control multi-select" id="my_select">
											    <?php
											    if(count($rutCosto)>0){
													foreach ($rutCosto as $key => $value){
														foreach ($value['usados'] as $v){
															echo "<option value='".$v['CCOSTO']."'>".substr($v['CCOSTO'],5)."-".$v['DESCRIPCION']."</option>";
														}
													}
												} 
												echo "<option value='' selected></option>";
												?>
											</select>
										</div>
										<label class="col-sm-2 control-label" style="text-align: left;">
											<i class="entypo-left-bold"></i>
											<b>Centro de costos que serán eliminados para este usuario</b>
										</label>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label"><b>opciones</b></label>
										<div class="col-sm-3">
										    <a href="<?php echo base_url();?>mantenedor/centro-costos">
												<button type="button" class="btn btn-info">
													<i class="entypo-left-bold"></i>
													Volver
												</button> 
											</a>
										</div>
										<div class="col-sm-3">
											<button id="input_borrar" type="button" class="btn btn-danger">
												<i class="entypo-cancel-circled"></i>
												Borrar
											</button>
										</div> 
									</div>
									<input type="hidden" name="input_rut" value="<?php echo $user[0]->USR_UID?>">
									<input type="hidden" name="activoBorrar" value="" id="activoBorrar">
								</form>
							</div>
						</div>
					</div>
				</div>
			</div> 
		</div>
	</div>
</div>
<!-- Modal 1 (Basic)-->
<div class="modal fade" id="modal-1">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Mensaje de confirmación</h4>
			</div>
			
			<div class="modal-body">
				<h2><b>¿Estas seguro de que quieres borrar los centros de costos seleccionados?</b></h2>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">cancelar</button>
				<button type="button" class="btn btn-info" id="input_confirmacion1" >Confirmar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-2">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Mensaje de alerta</h4>
			</div>
			<div class="modal-body">
				<h2><b>Primero debes seleccionar un centro de costo</b></h2>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" data-dismiss="modal">salir</button>
			</div>
		</div>
	</div>
</div>
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-icons/entypo/css/entypo.css">
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/neon-core.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/neon-theme.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/neon-forms.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/custom.css">

<script src="assets/js/jquery-1.11.0.min.js"></script>
<script>$.noConflict();</script>
<!-- Imported styles on this page -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/selectboxit/jquery.selectBoxIt.css">
<!-- Bottom scripts (common) -->
<script src="<?php echo base_url();?>assets/js/gsap/main-gsap.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap.js"></script>
<script src="<?php echo base_url();?>assets/js/joinable.js"></script>
<script src="<?php echo base_url();?>assets/js/resizeable.js"></script>
<!-- Imported scripts on this page -->
<script src="<?php echo base_url();?>assets/js/selectboxit/jquery.selectBoxIt.min.js"></script>
<!-- Imported styles on this page -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/select2/select2.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/icheck/skins/minimal/_all.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/icheck/skins/square/_all.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/icheck/skins/flat/_all.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/icheck/skins/futurico/futurico.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/icheck/skins/polaris/polaris.css">

<!-- Imported scripts on this page -->
<script src="<?php echo base_url();?>assets/js/bootstrap-tagsinput.min.js"></script>
<script src="<?php echo base_url();?>assets/js/typeahead.min.js"></script>
<script src="<?php echo base_url();?>assets/js/daterangepicker/moment.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.multi-select.js"></script>
<script src="<?php echo base_url();?>assets/js/icheck/icheck.min.js"></script>
<script src="<?php echo base_url();?>assets/js/neon-chat.js"></script>
<script type="text/javascript">
var $ = jQuery;

$(document).ready(function($) {
	$("#input_empresa").change(function(event) {
		$().val(' ');
		$("#form1").submit();
	});	

	$("#input_borrar").click(function(event) {
		if($("#my_select").val()!= ""){
 		   $('#modal-1').modal('show');
		}
		else
		{
			$("#modal-2").modal("show");
		}
	});


	$("#input_confirmacion1").click(function(event) {
		$("#activoBorrar").val("SI");
		$("#form1").submit();
	});

	if($("#mensaje_borrado").attr("id")!=undefined){
	   $('#mensaje_borrado').delay(5000).fadeOut();
	}
});
</script>

