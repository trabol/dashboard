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
				 <div class="panel-title"><h3><center>Permisos Usuario sobre los modulos </center></h3></div>
				 <div class="panel-options">
				  	 <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				  	  <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> 
				 </div>
			</div> 
		 	<div class="panel-body">
		 		<div class="row">
					<div class="col-md-12">
						<div class="alert alert-info"><strong>Info: </strong>
							Este administrador te permite editar las modulos asociados a los colaboradores.
						</div>
					</div>
					<?php if(isset($borrarEstado) && $borrarEstado==1):?>
					<div class="col-md-12" id="mensaje_borrado">
						<div class="alert alert-success"><strong>Mensaje: </strong>
								modulo editado correctamenete
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
						<div class="panel panel-info" data-collapsed="0">
							<div class="panel-heading">
								<div class="panel-title">
									Editar modulos de los usuarios
								</div>
								<div class="panel-options">
									<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
									<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
									<a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
								</div>
							</div>
							<div class="panel-body">
								<form  id="form1" role="form" class="form-horizontal form-groups-bordered" method="POST" action="<?php echo base_url();?>administracion/permisos/editar/<?php echo $user[0]->USR_UID;?>">
									<div class="form-group">
										<label class="col-sm-3 control-label">
											<b>seleccionar Perfil</b>
										</label>
										<div class="col-sm-5"> 
											<select name="input_perfil" class="form-control col-sm-5" id="input_perfil">
												<option <?php if(isset($input_perfil) && $input_perfil ==1){ echo "selected";}?> value="1">Adminitrador</option>
				                            	<option <?php if(isset($input_perfil) && $input_perfil ==2){ echo "selected";}?> value="2">Consultor
				                            	</option>
				                            </select>
				                        </div>
				                    </div>
									<div class="form-group">
										<label class="col-sm-3 control-label"><b>seleccionar modulos</b></label>
										<div class="col-sm-5"> 
												<select name="input_modulo" class="form-control col-sm-5" id="input_modulo">
				                                <option></option>
				                                <?php
				                               
				                                if(count($modulos)>0){
				                                	foreach ($modulos as $key => $value) {
				                                		$seledted='';
				                                		if($input_modulo==$value["id"]){ $seledted='selected';}
				                                		?>
				                                		<option <?php echo $seledted;?> value="<?php echo $value["id"];?>"><?php echo $value["nombre"];?></option>
				                                		<?php
				                                	}
				                                }
				                                ?>
											</select>
										</div> 
									</div>
									<?php if(count($subModulos)>0){ ?>
									<div class="form-group"> 
										<label class="col-sm-3 control-label">Sub Menu </label>
										<div class="col-sm-5">
										    <?php foreach ($subModulos as $key => $value) {?>
											<div class="checkbox">
											  	<label>
											  		<input <?php if(isset($value["estado"]) && $value["estado"]==1){ echo "checked";} ?> class="form-control" type="checkbox" name="chkSubModulo[<?php echo $value["ID"]?>]"> 
											  		<?php echo $value["NOMBRE"];?>
											  	</label>
											</div>
											<?php } ?>
										</div>
									</div>
									<?php } ?>
									<input type="hidden" name="USR_UID" value="<?php echo $user[0]->USR_UID?>">
									<input type="hidden" name="hi_opcion" value="" id="hi_opcion">
									<input type="button" name="enviar" class="btn-success" value="Guardar" id="btnSave">
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
				<h2><b>¿Estas seguro de que quieres borrar las cuenta contable seleccionadas?</b></h2>
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
				<h2><b>Primero debes seleccionar al menos una cuenta contable</b></h2>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" data-dismiss="modal">salir</button>
			</div>
		</div>
	</div>
</div>
<link rel="stylesheet"  href="<?php echo base_url();?>assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
<link rel="stylesheet"  href="<?php echo base_url();?>assets/css/font-icons/entypo/css/entypo.css">
<link rel="stylesheet"  href="<?php echo base_url();?>http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
<link rel="stylesheet"  href="<?php echo base_url();?>assets/css/bootstrap.css">
<link rel="stylesheet"  href="<?php echo base_url();?>assets/css/neon-core.css">
<link rel="stylesheet"  href="<?php echo base_url();?>assets/css/neon-theme.css">
<link rel="stylesheet"  href="<?php echo base_url();?>assets/css/neon-forms.css">
<link rel="stylesheet"  href="<?php echo base_url();?>assets/css/custom.css">

<script src="<?php echo base_url();?>assets/js/jquery-1.11.0.min.js"></script>
<script>$.noConflict();</script>


<!-- Bottom scripts (common) -->
<script src="<?php echo base_url();?>assets/js/gsap/main-gsap.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap.js"></script>
<script src="<?php echo base_url();?>assets/js/joinable.js"></script>
<script src="<?php echo base_url();?>assets/js/resizeable.js"></script>
<script src="<?php echo base_url();?>assets/js/neon-api.js"></script>


<!-- Imported scripts on this page -->
<script src="<?php echo base_url();?>assets/js/bootstrap-switch.min.js"></script>
<script src="<?php echo base_url();?>assets/js/neon-chat.js"></script>


<!-- JavaScripts initializations and stuff -->
<script src="<?php echo base_url();?>assets/js/neon-custom.js"></script>


<!-- Demo Settings -->
<script src="<?php echo base_url();?>assets/js/neon-demo.js"></script>


<script type="text/javascript">
var $ = jQuery;

$(document).ready(function($) {

	$("#btnSave").click(function(event) {
		$("#hi_opcion").val("saveForm");
		$("#form1").submit();
	});

	$("#input_modulo").change(function(event) {
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
		$("#form1").submit();
	});

	if($("#mensaje_borrado").attr("id")!=undefined){
	   $('#mensaje_borrado').delay(5000).fadeOut();
	}
});
</script>

