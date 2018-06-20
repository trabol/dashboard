<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary" data-collapsed="0"> 
			<div class="panel-heading">
				<div class="panel-title"><h3><center>Nueva Empresa</center></h3></div>
				<div class="panel-options">
				  	 <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				  	  <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> 
				</div>
			</div> 
			<div class="panel-body">
			<div class="row">
				<div class="col-md-12">
					<div class="row">
					<div class="col-md-12">
						<div class="alert alert-info"><strong>Info: </strong>
							Este administrador te permite crear nuevas empresas.
						</div>
					</div>
					<?php if($mensajeFinal == 1){?>
					<div class="col-md-12" id="mensaje_borrado">
						<div class="alert alert-success"><strong>Mensaje: </strong>
							Empresa creada correctamente
						</div>
					</div>
					<?php }?>
					</div>
					<br>
					<form role="form" class="form-horizontal form-groups-bordered" method="POST">
						<div class="form-group" id="grupoNombre">
							<label class="col-sm-3 control-label">Nombre empresa</label>
							<div class="col-sm-5">
								<div class="input-group">
									<span class="input-group-addon">-</span>
									<input  name="NOMBRE" id="NOMBRE" type="text" class="form-control" value="" placeholder="Ej: ISAPRE BANMÉDICA">
								</div>
							</div>
						</div>
						<div class="form-group" id="grupoCodigo">
							<label class="col-sm-3 control-label">Codigo empresa</label>
							<div class="col-sm-5">
								<div class="input-group">
									<span class="input-group-addon">-</span>
									<input  name="CODIGO" id="CODIGO" type="text" class="form-control" placeholder="Ej: CL01" value="">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Opciónes</label>
							<div class="col-sm-1">
								<div class="input-group">
									<a href="<?php echo base_url()?>empresas">
										<button type="button" class="btn btn-info">volver</button>
									</a>
								</div>
							</div>

							<div class="col-sm-4">
								<div class="inpt-group">
									<button type="button" class="btn btn-success" id="btn-guardar">Guardar</button>
								</div>
							</div>
						</div>
						<input type="hidden" id="hidden_opcion_sql" value="" name="hidden_opcion_sql">
					</form>
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
				<h4 class="modal-title">Mensaje error</h4>
			</div>
			
			<div class="modal-body">
				<h2><b>Error todos los campos son requeridos</b></h2>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" data-dismiss="modal">salir</button>
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
<script type="text/javascript">
var $ = jQuery;

	if($("#mensaje_borrado").attr("id")!=undefined){
	   $('#mensaje_borrado').delay(5000).fadeOut();
	}

	$("#btn-guardar").click(function(event) {
		/* Act on the event */
		$(".form-group").removeClass('has-error');
		var nombre = $("#NOMBRE").val();
		var codigo = $("#CODIGO").val();
		var estado = true;

		if(nombre ==""){
		   estado = false;
		   $("#grupoNombre").addClass('has-error');
		}
		if(codigo ==""){
		   estado = false;
		   $("#grupoCodigo").addClass('has-error');
		}
		if(estado){
		   $("#hidden_opcion_sql").val("insertar");
		   $("form").submit();
		}else{
			$('#modal-1').modal('show');
		}
	});
</script>


