<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style type="text/css">
	.ms-list{
		width: 200px!important;
	}
	b{
		color:black;
		font:15px;
	}
	#input_borrar{
		float: right;
		margin-right: 40px;
	}
</style>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary" data-collapsed="0"> 
			<div class="panel-heading">
				 <div class="panel-title"><h3><center>Editar usuario </center></h3></div>
				 <div class="panel-options">
				  	 <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				  	  <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> 
				 </div>
			</div> 
		 	<div class="panel-body">
		 		<div class="row">
					<div class="col-md-12">
						<div class="alert alert-info"><strong>Info: </strong>
							Este administrador te permite editar los datos del usuario.
						</div>
					</div>
					<?php if($mensajeFinal == 1){?>
					<div class="col-md-12" id="mensaje_borrado">
						<div class="alert alert-success"><strong>Mensaje: </strong>
							Usuario editado correctamente
						</div>
					</div>
					<?php }?>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary" data-collapsed="0">
							<div class="panel-heading">
								<div class="panel-title">
									Formulario de edición
								</div>
								
								<div class="panel-options">
									<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
									<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
									<a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
									<a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
								</div>
							</div>
							<div class="panel-body">
								<form role="form" class="form-horizontal form-groups-bordered" method="POST">
									<div class="form-group" id="grupoNombre">
										<label class="col-sm-3 control-label">Nombre</label>
										<div class="col-sm-5">
											<div class="input-group">
												<span class="input-group-addon">-</span>
												<input  name="nombre" id="nombre" type="text" class="form-control" value="<?php echo $user[0]->USR_FIRSTNAME;?>">
											</div>
										</div>
									</div>
									
									<div class="form-group" id="grupoApellido">
										<label class="col-sm-3 control-label">Apellido</label>
										<div class="col-sm-5">
											<div class="input-group">
												<span class="input-group-addon">-</span>
												<input name="apellido" id="apellido" type="text" class="form-control" value="<?php echo $user[0]->USR_LASTNAME;?>">
											</div>
										</div>
									</div>
									
									<div class="form-group" id="grupoUsuario" >
										<label class="col-sm-3 control-label">Usuario</label>
										<div class="col-sm-5" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="soló puede ser cambiado mediante una solicitud" data-original-title="Campo no editable">
											<div class="input-group">
												<span class="input-group-addon">-</span>
												<input disabled="disabled" name="usuario" id="usuario" type="text" class="form-control" value="<?php echo $user[0]->USR_USERNAME;?>">
											</div>
										</div>
									</div>
									<div class="form-group" id="grupoCorreo">
										<label class="col-sm-3 control-label">Correo</label>
										<div class="col-sm-5">
											<div class="input-group">
												<span class="input-group-addon">@</span>
												<input name="correo" id="correo" type="text" class="form-control" value="<?php echo $user[0]->USR_EMAIL;?>">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Sociedades</label>
										<div class="col-sm-5">
											<div class="input-group" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="soló puede ser cambiado mediante una solicitud" data-original-title="Campo no editable">
												<span class="input-group-addon">-</span>
												<input type="text" class="form-control"  disabled="disabled" value="Vida Tres">
												<input type="text" class="form-control"  disabled="disabled" value="Banmedica">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Sustituido por</label>
										<div class="col-sm-5" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="soló puede ser cambiado mediante una solicitud" data-original-title="Campo no editable">
											<div class="input-group">
												<span class="input-group-addon">-</span>
												<select name="sustitucion" class="form-control">
													<option value="<?php if(count($sustituto)>0){ echo $sustituto[0]['USR_UID'];}?>">
													<?php if(count($sustituto)>0){
														echo $sustituto[0]['USR_FIRSTNAME']." ".$sustituto[0]["USR_LASTNAME"];
													}?>
													</option>
													<?php
													if(count($usuarios)>0){
														foreach ($usuarios as $key => $value) {
															echo "<option value='".$value['USR_UID']."'>".strtoupper($value['USR_FIRSTNAME']." ".$value['USR_LASTNAME'])."</option>";
														}

													}
													?>						
												</select>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Grupo o cargo</label>
										<div class="col-sm-5" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="soló puede ser cambiado mediante una solicitud" data-original-title="Campo no editable">
											<div class="input-group">
												<span class="input-group-addon">-</span>
												<?php if(count($user)>0){
													foreach ($user as $key => $value) {
														foreach ($value->grupos as $g){?>
															<input type="text" class="form-control"  disabled="disabled" value="<?php echo $g->CON_VALUE;?>"><?php
														}
													}
												}
												?>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Opciones</label>
										<div class="col-sm-3">
											<div class="input-group">
												<a href="<?php echo base_url();?>mantenedor/usuarios-bpm/">
												<button type="button" class="btn btn-info">
													<i class="entypo-left-bold"></i>
													Volver
												</button>
												</a>
											</div>
										</div>
										<div class="col-sm-5">
											<div class="input-group">
												<button type="button" class="btn btn-success" id="input_guardar">Guardar</button>
											</div>
										</div>
									</div>
									<input type="hidden" name="input_hidden" value="0" id="input_hidden">
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
				<h2><b>¿Estas seguro de que quieres cambiar los datos de este usuario?</b></h2>
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
				<h2><b>Los datos ingresados son incorrectos</b></h2>
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

	$("#input_guardar").click(function(event) {
		if(validarGuardado()){
 		   $('#modal-1').modal('show');
		}
		else
		{
			$("#modal-2").modal("show");
		}
	});


	if($("#mensaje_borrado").attr("id")!=undefined){
	   $('#mensaje_borrado').delay(5000).fadeOut();
	}
	$("#input_confirmacion1").click(function(event) {
		/* Act on the event */
		$("#input_hidden").val(1);
		var uno = $("#input_hidden").attr("value");
		$("form").submit();
	});
});
function validarGuardado(){
	$(".form-group").removeClass('has-error')
	var nombre   =$("#nombre").val();
	var apellido =$("#apellido").val();
	var usuario  =$("#usuario").val();
	var correo   =$("#correo").val();
	var estado   = true;
	
	if(nombre == ""){
		estado = false;
		$("#grupoNombre").addClass('has-error');
	}
	if(apellido ==""){
		estado = false;
		$("#grupoApellido").addClass('has-error');

	}
	if(correo == ""){
		estado = false;
		$("#grupoCorreo").addClass('has-error');
	}else{
		if(!validarMail(correo)){
			estado = false;
			$("#grupoCorreo").addClass('has-error');
		}
	}
	return estado;
}
function validarMail(mail){
	var emailRegex =/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
	var estado = false;
    //Se muestra un texto a modo de ejemplo, luego va a ser un icono
    if(emailRegex.test(mail)) {
       estado = true;
    } 
    return estado;
}
</script>

